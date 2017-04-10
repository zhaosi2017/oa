<?php

namespace app\modules\product\models;

use Yii;
use app\models\CActiveRecord;
use app\modules\user\models\Company;
use app\modules\user\models\User;

/**
 * This is the model class for table "root_category".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $visible
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 */
class RootCategory extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'root_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_author_uid', 'update_author_uid', 'visible', 'company_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => '所属公司',
            'name' => '根分类名称设置',
            'visible' => '可见',
            'create_author_uid' => 'Create Author Uid',
            'update_author_uid' => 'Update Author Uid',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return RootCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RootCategoryQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->name = Yii::$app->security->decryptByKey(base64_decode($this->name), Yii::$app->params['inputKey']);
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
            }else{
                $this->name = base64_encode(Yii::$app->security->encryptByKey($this->name,Yii::$app->params['inputKey']));
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
        return $this->hasOne(User::className(), ['id' => 'create_author_uid']);
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
