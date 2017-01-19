<?php

namespace app\modules\customer\models;

use Yii;
use app\models\CActiveRecord;
/**
 * This is the model class for table "group_rate".
 *
 * @property string $rate_company_id
 * @property string $company_id
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
            [['company_id', 'rater_uid', 'grade'], 'required'],
            [['rater_uid', 'grade', 'company_id', 'rate_company_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate_company_id' => '当前所在公司',
            'company_id' => 'Company ID',
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
        $this->rate_company_id = $identity->company_id;
        $this->rater_uid = $uid;
        $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        if ($this->isNewRecord) {
            $this->create_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        }
        return true;
    }
}
