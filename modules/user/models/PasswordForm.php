<?php

namespace app\modules\user\models;

use yii\base\Model;
use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PasswordForm extends Model
{
    public $password;
    public $rePassword;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['rePassword', 'password'], 'required'],
//            [['rePassword', 'password'], 'string', 'length' => [8,15]],
            ['rePassword', 'compare', 'compareAttribute'=>'password'],
            ['password', 'match', 'pattern' => '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{9,15}/', 'message'=>'密码必须包含大写字母、小写字母和数字,且大于8位。'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => '新密码',
            'rePassword' => '重复输入',
        ];
    }

    public function updateSave()
    {
        if($this->validate(['password'])){
            if(Yii::$app->user->id){
                $user = User::findOne(Yii::$app->user->id);
                $user->password = $this->password;
                return $user->update();
            }
            Yii::$app->getSession()->setFlash('error', '操作失败');
        }
        return false;
    }

}
