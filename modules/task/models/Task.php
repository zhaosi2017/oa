<?php

namespace app\modules\task\models;

//use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $company_customer_id
 * @property integer $execute_type
 * @property integer $fee_settlement
 * @property integer $customer_category
 * @property integer $customer_grate
 * @property integer $product_id
 * @property string $requirement
 * @property string $attachment
 * @property integer $status
 * @property integer $superior_task_id
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property integer $create_time
 * @property integer $update_time
 */
class Task extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'product_id','customer_category', 'company_customer_id', 'customer_grate', 'requirement', 'superior_task_id', 'create_author_uid', 'update_author_uid'], 'required'],
            [['company_id', 'company_customer_id','execute_type', 'fee_settlement', 'customer_category', 'customer_grate', 'product_id', 'status', 'superior_task_id', 'create_author_uid', 'update_author_uid', 'create_time', 'update_time'], 'integer'],
            [['requirement'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['execute_type', 'fee_settlement'], 'default', 'value' => 0],
            [['attachment'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '任务名称',
            'company_id' => '所属公司',
            'execute_type' => '执行方式',
            'fee_settlement' => '费用结算',
            'customer_category' => '客户类别',
            'customer_grate' => '客户级别',
            'company_customer_id' => '集团公司/外部客户名称',
            'product_id' => '产品编号',
            'requirement' => '任务要求',
            'attachment' => '附件',
            'status' => 'Status',
            'superior_task_id' => 'Superior Task ID',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
