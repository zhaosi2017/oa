<?php

namespace app\modules\task\models;

use app\modules\system\models\SerialNumber;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "task_pay_info".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $pay_company_id
 * @property integer $execute_company_id
 * @property string $pay_bill_no
 * @property integer $status
 * @property integer $type
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class TaskPayInfo extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_pay_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['task_id', 'pay_bill_no', 'create_author_uid', 'update_author_uid'], 'required'],
            [['task_id', 'pay_company_id', 'execute_company_id', 'status', 'type', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['pay_bill_no'], 'string', 'max' => 64],
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
            'pay_company_id' => 'Pay Company ID',
            'execute_company_id' => 'Execute Company ID',
            'pay_bill_no' => '付款单编号',
            'status' => '状态',
            'type' => 'Type',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskPayInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPayInfoQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $model = new SerialNumber();
                $serial = $model->generalSerial('pay');
                $this->pay_bill_no = date('ymd', $_SERVER['REQUEST_TIME']) . $serial;
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

    public function getExecuteCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'execute_company_id'])->alias('executeCompany');
    }

    public function getPayCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'pay_company_id'])->alias('payCompany');
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(),['id'=>'task_id'])->alias('task');
    }

    public function getDealPrice()
    {
        return $this->hasMany(TaskDealPrice::className(),['task_id'=>'task_id']);
    }

    public function getExecuteInfo()
    {
        return $this->hasOne(TaskExecuteInfo::className(),['task_id'=>'task_id']);
    }
}
