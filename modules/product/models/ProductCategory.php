<?php

namespace app\modules\product\models;

use Yii;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use app\models\CActiveRecord;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $superior_id
 * @property integer $company_id
 * @property integer $avisible
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class ProductCategory extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['superior_id', 'name'], 'required'],
            [['superior_id', 'company_id', 'avisible', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'checkName'],
//            [['name'], 'unique', 'targetAttribute'=>['name','company_id'],'message'=>'同一公司下不能有相同分类。'],
        ];
    }

    /**
     * @param null $update_name
     * @return array ['id'=>'name_cid']
     */
    public function allNameCid($update_name = null)
    {
        $lists = ProductCategory::find()
            ->select(['name','company_id','id'])
            ->where(['company_id'=>$this->company_id])
            ->indexBy('id')->asArray()->all();
        foreach ($lists as $id => $list){
            $dec_name = Yii::$app->security->decryptByKey(base64_decode($list['name']), Yii::$app->params['inputKey']);
            $update_name !=  $dec_name && $lists[$id] = $dec_name . '_' . $list['company_id'];
        }
        return $lists;
    }

    public function checkName($attribute)
    {
        if($this->isNewRecord){
            if(in_array($this->name .'_' . $this->company_id, $this->allNameCid())){
                $this->addError($attribute, '同一公司下不能有相同分类。');
            }
        }else{
            if(in_array($this->name .'_' . $this->company_id, $this->allNameCid($this->name))){
                $this->addError($attribute, '同一公司下不能有相同分类。');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'superior_id' => '上级分类',
            'company_id' => 'Company ID',
            'avisible' => '可见',
            'status' => '状态',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }

    public function categoryList(){
        $condition = $this->isNewRecord ? ['status'=>0,'superior_id'=>0] : ['and','status=0','superior_id=0', ['not in', 'id',$this->id]];
        $res = $this::find()->select(['name','id'])->where($condition)->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
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
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_author_uid']);
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
     * 获取公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

    /**
     * 获取上级
     * @return \yii\db\ActiveQuery
     */
    public function getSuperior()
    {
        return $this->hasOne($this::className(), ['id' => 'superior_id'])->alias('superior');
    }

}
