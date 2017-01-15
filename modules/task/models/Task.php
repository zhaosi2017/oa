<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $execute_type
 * @property integer $fee_settlement
 * @property integer $customer_category
 * @property integer $customer_grate
 * @property string $company_cuntomer_name
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
class Task extends \app\models\CActiveRecord
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
            [['name', 'company_cuntomer_name', 'product_id', 'requirement', 'superior_task_id', 'create_author_uid', 'update_author_uid'], 'required'],
            [['execute_type', 'fee_settlement', 'customer_category', 'customer_grate', 'product_id', 'status', 'superior_task_id', 'create_author_uid', 'update_author_uid', 'create_time', 'update_time'], 'integer'],
            [['requirement'], 'string'],
            [['name', 'company_cuntomer_name'], 'string', 'max' => 40],
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
            'name' => 'Name',
            'execute_type' => 'Execute Type',
            'fee_settlement' => 'Fee Settlement',
            'customer_category' => 'Customer Category',
            'customer_grate' => 'Customer Grate',
            'company_cuntomer_name' => 'Company Cuntomer Name',
            'product_id' => 'Product ID',
            'requirement' => 'Requirement',
            'attachment' => 'Attachment',
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
