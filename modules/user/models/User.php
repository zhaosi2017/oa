<?php

namespace app\modules\user\models;

use Yii;
use app\models\CActiveRecord;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $account
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property string $company_name
 * @property integer $department_id
 * @property integer $posts_id
 * @property integer $status
 * @property integer $login_permission
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class User extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'company_name', 'department_id', 'posts_id'], 'required'],
            [['department_id', 'posts_id', 'status', 'login_permission', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['account'], 'string', 'max' => 20],
            [['nickname', 'password'], 'string', 'max' => 64],
            [['company_name', 'email'], 'string', 'max' => 30],
            [['account'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => '用户名称',
            'nickname' => '昵称',
            'email' => '验证邮箱',
            'password' => '密码',
            'auth_key' => '认证密钥',
            'company_name' => '所属公司',
            'department_id' => '所属部门',
            'posts_id' => '所属岗位',
            'status' => '状态',
            'login_permission' => '登录权限',
            'create_author_uid' => '创建人',
            'update_author_uid' => '最后修改人',
            'create_time' => '创建时间',
            'update_time' => '最后修改时间',
        ];
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $this->update_author_uid = $uid;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_author_uid = $uid;
                $this->auth_key = Yii::$app->security->generateRandomString();
            }else{
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


}
