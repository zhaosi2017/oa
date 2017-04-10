<?php

namespace app\modules\customer\models;

use Yii;
use app\models\CActiveRecord;
use app\modules\user\models\Company;
use app\modules\user\models\User;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $grade
 * @property string $remarks
 * @property integer $status
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class Customer extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['grade', 'company_id','status', 'create_author_uid', 'update_author_uid'], 'integer'],
            [['remarks'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'uniqueName'],
        ];
    }

    public function uniqueName($attribute)
    {
        $model = $this::find()->select(['name','id']);
        $list = $model->indexBy('id')->column();
        foreach ($list as $id => $name)
        {
            $dec_value = Yii::$app->security->decryptByKey(base64_decode($name), Yii::$app->params['inputKey']);
            if($this->isNewRecord){
                if($this->name == $dec_value){
                    $this->addError($attribute, '该名称已被占用。');
                }
            }else{
                if($this->name == $dec_value && $this->id != $id){
                    $this->addError($attribute, '该名称已被占用。');
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '客户名称',
            'company_id' => '所属公司编号',
            'grade' => '级别',
            'remarks' => '备注',
            'status' => 'Status',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
        $this->remarks && $this->remarks = Yii::$app->security->decryptByKey(base64_decode($this->remarks), Yii::$app->params['inputKey']);
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_author_uid = $uid;
                $this->update_author_uid = $uid;
                $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->remarks && $this->remarks = base64_encode(Yii::$app->security->encryptByKey($this->remarks,Yii::$app->params['inputKey']));
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
                $this->remarks && $this->remarks = base64_encode(Yii::$app->security->encryptByKey($this->remarks,Yii::$app->params['inputKey']));
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

    /**
     * 获取公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }
}
