<?php

namespace app\modules\system\models;

use Yii;

/**
 * This is the model class for table "notice_queue_user".
 *
 * @property integer $id
 * @property integer $uid
 */
class NoticeQueueUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_queue_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
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
        ];
    }

    /**
     * @inheritdoc
     * @return NoticeQueueUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoticeQueueUserQuery(get_called_class());
    }
}
