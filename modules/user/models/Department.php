<?php

namespace app\modules\user\models;

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
            [['name'], 'unique', 'targetAttribute'=>['name','company_id'],'message'=>'同一公司下不能有相同部门。'],
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
        return Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
    }
}
