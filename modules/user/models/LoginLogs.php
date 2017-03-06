<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "login_logs".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $unlock_uid
 * @property integer $status
 * @property string $login_time
 * @property string $unlock_time
 * @property string $login_ip
 */
class LoginLogs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'status', 'unlock_uid'], 'integer'],
            [['login_time'], 'safe'],
            [['login_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'status' => 'Status',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
        ];
    }

    /**
     * @inheritdoc
     * @return LoginLogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LoginLogsQuery(get_called_class());
    }

    public function getStatuses()
    {
        return [
            0 => '登录成功',
            1 => '已解锁',
            2 => '密码错误',
            3 => '验证错误',
            4 => 'IP锁定中',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'uid']);
    }

    public function getOperator()
    {
        return $this->hasOne(User::className(),['id'=>'unlock_uid']);
    }
}
