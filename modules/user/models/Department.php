<?php

namespace app\modules\user\models;

//use Yii;
use app\models\CActiveRecord;
/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $name
 * @property string $company_name
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
            [['name', 'company_name'], 'required'],
            [['superior_department_id', 'status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'company_name'], 'string', 'max' => 20],
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
            'company_name' => '所属公司',
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
}
