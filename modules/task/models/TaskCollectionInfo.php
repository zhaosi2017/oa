<?php

namespace app\modules\task\models;

use app\modules\customer\models\Customer;
use app\modules\system\models\SerialNumber;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "task_collection_info".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $company_id
 * @property string $receipt_no
 * @property integer $status
 * @property integer $type
 * @property integer $company_customer_id
 * @property integer $customer_category
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 * @property string $remark
 */
class TaskCollectionInfo extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_collection_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['task_id', 'create_author_uid', 'update_author_uid'], 'required'],
            [['task_id', 'company_id', 'status', 'type', 'company_customer_id', 'customer_category', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['receipt_no','remark'], 'string', 'max' => 64],
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
            'company_id' => 'Company ID',
            'receipt_no' => '收款单编号',
            'status' => 'Status',
            'type' => '收款方式',
            'company_customer_id' => 'Company Customer ID',
            'customer_category' => 'Customer Category',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'remark' => '收款备注',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskCollectionInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskCollectionInfoQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $model = new SerialNumber();
                $serial = $model->generalSerial('receipt');
                $this->receipt_no = date('ymd', $_SERVER['REQUEST_TIME']) . $serial;
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }else{
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
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

    public function getTask()
    {
        return $this->hasOne(Task::className(),['id'=>'task_id'])->alias('task');
    }

    /**
     * 获取收款公司
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'company_id'])->alias('receiptCompany');
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(),['id'=>'company_customer_id'])->alias('customer');
    }

    public function getGroup()
    {
        return $this->hasOne(Company::className(),['id'=>'company_customer_id'])->alias('group');
    }

    public function getDealPrice()
    {
        return $this->hasMany(TaskDealPrice::className(),['task_id'=>'task_id'])->alias('dealPrice');
    }
}
