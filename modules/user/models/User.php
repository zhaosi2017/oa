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
            [['account'], 'string', 'max' => 10],
            [['nickname', 'password', 'auth_key'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 30],
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
        return Company::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();
    }

    public function getDepartmentList()
    {
        $model = Department::find()->select(['name','id'])->where(['status'=>0]);
        if(Yii::$app->request->get('UserSearch')){
            $search = Yii::$app->request->get('UserSearch');
            $model->andWhere(['company_id'=>$search['company_id']]);
        }
        return $model->indexBy('id')->column();
    }

    public function getPostsList()
    {
        $model = Posts::find()->select(['name','id'])->where(['status'=>0]);
        if(Yii::$app->request->get('UserSearch')){
            $search = Yii::$app->request->get('UserSearch');
            $model->andWhere(['department_id'=>$search['department_id'],'company_id'=>$search['company_id']]);
        }
        return $model->indexBy('id')->column();
    }

}
