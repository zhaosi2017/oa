<?php

namespace app\modules\task\models;

//use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_deal_price".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $product_id
 * @property integer $money_id
 * @property string $price
 * @property string $purchase_price
 */
class TaskDealPrice extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_deal_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'product_id', 'money_id'], 'integer'],
            [['price', 'purchase_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'money_id' => 'Money ID',
            'price' => 'Price',
            'purchase_price' => '购买价格',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskDealPriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskDealPriceQuery(get_called_class());
    }

    public function getTaskCollectionInfo()
    {
        return $this->hasOne(TaskCollectionInfo::className(),['task_id'=>'task_id']);
    }

    public function getTaskPayInfo()
    {
        return $this->hasOne(TaskPayInfo::className(),['task_id'=>'task_id']);
    }
}
