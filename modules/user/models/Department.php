<?php

namespace app\modules\user\models;

use Yii;
use app\models\CActiveRecord;
/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property integer $superior_department_id
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Department extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'company_id', 'superior_department_id'], 'required'],
            [['superior_department_id', 'company_id','status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            //同一公司下不能有相同部门.
//            [['name'], 'unique', 'targetAttribute'=>['name','company_id'],'message'=>'同一公司下不能有相同部门。'],
            [['name'], 'checkDepartment']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '部门名称',
            'company_id' => '所属公司',
            'superior_department_id' => '上级部门',
            'status' => '状态',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => '创建时间',
            'update_time' => '最后修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name, Yii::$app->params['inputKey']));
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name, Yii::$app->params['inputKey']));
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    /*public function decryptDepartment($update_department = null)
    {
        $departments = Department::find()->select(['name','id'])->indexBy('id')->column();
        foreach ($departments as $id => $name)
        {
            $decryptName = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
            $update_department!=$decryptName && $departments[$id] = $decryptName;
        }
        return $departments;
    }*/

    /**
     * @param null $update_department
     * @return Department[]|array ['id'=>'name_cid']
     */
    public function uniqueDepartment($update_department = null)
    {
        $lists = Department::find()
            ->select(['name','company_id','id'])
            ->where(['company_id'=>$this->company_id])
            ->indexBy('id')->asArray()->all();
        foreach ($lists as $id => $list){
            $dec_department = Yii::$app->security->decryptByKey(base64_decode($list['name']), Yii::$app->params['inputKey']);
            $update_department !=  $dec_department && $lists[$id] = $dec_department . '_' . $list['company_id'];
        }
        return $lists;
    }

    public function checkDepartment($attribute)
    {
        if($this->isNewRecord){
            /*if(in_array($this->name, $this->decryptDepartment())){
                $this->addError($attribute, '部门名称已存在。');
            }*/
            //同一公司下不能有相同部门.
            if(in_array($this->name .'_' . $this->company_id, $this->uniqueDepartment())){
                $this->addError($attribute, '同一公司下不能有相同部门。');
            }
        }else{
            /*if(in_array($this->name, $this->decryptDepartment($this->name))){
                $this->addError($attribute, '部门名称已存在。');
            }*/
            if(in_array($this->name .'_' . $this->company_id, $this->uniqueDepartment($this->name))){
                $this->addError($attribute, '同一公司下不能有相同部门。');
            }
        }

    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_author_uid'])->alias('creator');
    }

    /**
     * 获取最后修改人
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'update_author_uid'])->alias('updater');
    }

    /**
     * 获取上级
     * @return \yii\db\ActiveQuery
     */
    public function getSuperior()
    {
        return $this->hasOne($this::className(), ['id' => 'superior_department_id'])->alias('superior');
    }

    /**
     * 获取公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

    public function getCompanyList()
    {
        $list = Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
        foreach ($list as $id=>$name){
            $list[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $list;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        $id = $this->id;
        $self = $this::findOne(['id'=>$id,'status'=>0]);

        /*$sql = 'select id,superior_department_id,name from
                  (select * from '.Department::tableName().' where superior_department_id>0 order by id desc) real_name_sorted,
                  (select @pv :='.$id.') initialisation
                  where (find_in_set(superior_department_id,@pv)>0 and @pv := concat(@pv,",",id))';
        $children = [] + Department::getDb()->createCommand($sql)->queryAll();*/

        $real_name_sorted = $this::find()->where(['>','superior_department_id',0])->orderBy(['id'=>SORT_DESC]);
        $children = [] + $this::find()->select(['id','superior_department_id','name'])
                ->from(['real_name_sorted'=>$real_name_sorted,'initialisation'=>'(select @pv :='.$id.')'])
                ->where(['>','find_in_set(superior_department_id,@pv)',0])
                ->andWhere('@pv :=concat(@pv,",",id)')->all();

        array_unshift($children, $self);

        return $children;
    }
}
