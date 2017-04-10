<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Connection;
use app\models\CActiveRecord;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $account
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property integer $company_id
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
            [['account', 'company_id', 'department_id', 'posts_id'], 'required'],
            [['company_id', 'department_id', 'posts_id', 'status', 'login_permission', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
//            [['account'], 'string', 'max' => 10],
            [['nickname', 'password', 'auth_key'], 'string', 'max' => 64],
//            [['email'], 'string', 'max' => 30],
            [['account'], 'checkAccount'],
            [['email'], 'checkEmail'],
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
            'company_id' => '所属公司',
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

    public function checkAccount($attribute)
    {
        $model = $this::find()->select(['account','id']);
        $accounts = $model->indexBy('id')->column();
        foreach ($accounts as $id => $account)
        {
            $dec_value = Yii::$app->security->decryptByKey(base64_decode($account), Yii::$app->params['inputKey']);
            if($this->isNewRecord){
                if($this->account == $dec_value){
                    $this->addError($attribute, '用户名已存在。');
                }
            }else{
                if($this->account == $dec_value && $this->id != $id){
                    $this->addError($attribute, '用户名已存在。');
                }
            }
        }

    }

    public function checkEmail($attribute)
    {
        $model = $this::find()->select(['email','id']);
        $list = $model->indexBy('id')->column();
        foreach ($list as $id => $email)
        {
            $dec_value = Yii::$app->security->decryptByKey(base64_decode($email), Yii::$app->params['inputKey']);
            if($this->isNewRecord){
                if($this->email == $dec_value){
                    $this->addError($attribute, '该邮箱已被占用。');
                }
            }else{
                if($this->email == $dec_value && $this->id != $id){
                    $this->addError($attribute, '该邮箱已被占用。');
                }
            }
        }

    }

    public function createBbsAccount($obj)
    {
        $forum_user = [
            'username' => $obj->account,
            'username_clean' => $obj->account,
            'group_id' => 7,
            'user_permissions' => '00000000000v667wt0hwba88000000',
            'user_posts' => 2,
            'user_email_hash' => 1,
            'user_password' => '$2y$10$tlzE4IqLfC.QErcnO5.0QOtsTGvejBZ7tzZDUJrkYE8EpYMQYFXaq',
            'user_sig' => '',
        ];
        $obj->email && $forum_user['email'] = $obj->email;

        $db = new Connection([
            'dsn' => 'mysql:host=localhost;dbname=phpbb',
            'username' => 'root',
            'password' => 'OASystem@Yii2+H+',
            'charset' => 'utf8',
        ]);

        $db->createCommand()->insert('phpbb_users', $forum_user)->execute();
        $id = $db->getLastInsertID();
        $db->createCommand()->insert('phpbb_user_group', [
            'user_id'=>$id,
            'group_id'=>8,
            'user_pending'=>0,
        ])->execute();

        return true;
    }

    public function updateBbsAccount($obj)
    {
        $db = new Connection([
            'dsn' => 'mysql:host=localhost;dbname=phpbb',
            'username' => 'root',
            'password' => 'OASystem@Yii2+H+',
            'charset' => 'utf8',
        ]);

        $updateField = ['user_email_hash'=>1];
        $obj->email && $updateField['user_email'] = $obj->email;
        $obj->password && $updateField['user_password'] = file_get_contents('http://localhost/phpbb3/encrypt.php?password='.$obj->password);
        $db->createCommand()->update('phpbb_users',$updateField,['username'=>$obj->account])->execute();
        return true;
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $this->update_author_uid = $uid;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->createBbsAccount($this); //添加论坛用户
                $this->create_author_uid = $uid;
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->account = base64_encode(Yii::$app->security->encryptByKey($this->account, Yii::$app->params['inputKey']));
                $this->email && $this->email = base64_encode(Yii::$app->security->encryptByKey($this->email, Yii::$app->params['inputKey']));
            }else{
                $this->updateBbsAccount($this); //修改论坛用户
                $this->password && $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->account = base64_encode(Yii::$app->security->encryptByKey($this->account, Yii::$app->params['inputKey']));
                $this->email && $this->email = base64_encode(Yii::$app->security->encryptByKey($this->email, Yii::$app->params['inputKey']));
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->account = Yii::$app->security->decryptByKey(base64_decode($this->account), Yii::$app->params['inputKey']);
        $this->email && $this->email = Yii::$app->security->decryptByKey(base64_decode($this->email), Yii::$app->params['inputKey']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne($this::className(), ['id' => 'create_author_uid'])->alias('creator');
    }

    /**
     * 获取最后修改人
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne($this::className(), ['id' => 'update_author_uid'])->alias('updater');
    }

    /**
     * 获取公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

    /**
     * 获取部门
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id'])->alias('department');
    }

    /**
     * 获取岗位
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Posts::className(), ['id' => 'posts_id'])->alias('posts');
    }

    public function getCompanyList()
    {
        $list = Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
        foreach ($list as $id=>$name){
            $list[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $list;
    }

    public function getDepartmentList()
    {
        $model = Department::find()->select(['name','id'])->where(['status'=>0]);
        if(Yii::$app->request->get('UserSearch')){
            $search = Yii::$app->request->get('UserSearch');
            $model->andWhere(['company_id'=>$search['company_id']]);
        }
        $res = $model->indexBy('id')->column();

        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }

    public function getPostsList()
    {
        $model = Posts::find()->select(['name','id'])->where(['status'=>0]);
        if(Yii::$app->request->get('UserSearch')){
            $search = Yii::$app->request->get('UserSearch');
            $model->andWhere(['department_id'=>$search['department_id'],'company_id'=>$search['company_id']]);
        }
        $res = $model->indexBy('id')->column();
        foreach ($res as $id => $name){
            $res[$id] = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
        }
        return $res;
    }

}
