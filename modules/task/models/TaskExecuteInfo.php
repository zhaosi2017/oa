<?php

namespace app\modules\task\models;

//use Yii;
use app\models\CActiveRecord;
use app\modules\user\models\Company;
use app\modules\user\models\User;

/**
 * This is the model class for table "task_execute_info".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $task_id
 * @property integer $money_id
 * @property string $price
 * @property string $finish_time
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class TaskExecuteInfo extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_execute_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'task_id', 'money_id', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['price'], 'number'],
            [['finish_time'], 'string'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => '执行公司',
            'task_id' => 'Task ID',
            'money_id' => 'Money ID',
            'price' => '执行价格',
            'finish_time' => '预计完成时间',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskExecuteInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskExecuteInfoQuery(get_called_class());
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

    public function getCompany()
    {
        return $this->hasOne(Company::className(),['id'=>'company_id']);
    }

    public function getUser()
    {
        return $this->hasMany(User::className(),['company_id'=>'company_id']);
    }
}
