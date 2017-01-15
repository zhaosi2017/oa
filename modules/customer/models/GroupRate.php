<?php

namespace app\modules\customer\models;

use Yii;
use app\models\CActiveRecord;
/**
 * This is the model class for table "group_rate".
 *
 * @property string $rate_company_name
 * @property string $company_name
 * @property integer $rater_uid
 * @property integer $grade
 * @property string $create_time
 * @property string $update_time
 */
class GroupRate extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'rater_uid', 'grade'], 'required'],
            [['rater_uid', 'grade'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['company_name','rate_company_name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate_company_name' => '当前所在公司',
            'company_name' => 'Company Name',
            'rater_uid' => 'Rater Uid',
            'grade' => 'Grade',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return GroupRateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupRateQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;

        $identity = (Object) Yii::$app->user->identity;
        $this->rate_company_name = $identity->company_name;
        $this->rater_uid = $uid;
        $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        if ($this->isNewRecord) {
            $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        }
        return true;
    }
}
