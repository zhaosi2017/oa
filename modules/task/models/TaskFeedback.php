<?php

namespace app\modules\task\models;

use app\modules\user\models\User;
use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "task_feedback".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $content
 * @property string $attachment
 * @property integer $create_author_uid
 * @property integer $create_time
 * @property integer $type
 * @property integer $status
 */
class TaskFeedback extends CActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'create_author_uid', 'create_time', 'type', 'status'], 'integer'],
            [['content'], 'string', 'max' => 500],
            [['attachment'], 'string', 'max' => 64],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip, rar, 7z', 'maxSize'=>1024*1024*10, 'tooBig'=>'文件上传过大！大小不能超过10M',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'content' => 'Content',
            'attachment' => 'Attachment',
            'create_author_uid' => 'Create Author Uid',
            'create_time' => 'Create Time',
            'type' => 'Type',
            'status' => 'Status',
            'file' => '附件',
        ];
    }

    public function getTypes()
    {
        return [
            0 => '执行反馈',
            1 => '作废',
            2 => '验收不通过',
            3 => '结算',
            4 => '已完成',
            5 => '无法执行',
            6 => '任务撤销',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskFeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskFeedbackQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->content = Yii::$app->security->decryptByKey(base64_decode($this->content), Yii::$app->params['inputKey']);
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;

        if ($this->isNewRecord) {
            $this->create_author_uid = $uid;
            $this->create_time = $_SERVER['REQUEST_TIME'];
            $this->content = base64_encode(Yii::$app->security->encryptByKey($this->content,Yii::$app->params['inputKey']));
            return true;
        }

        return true;
    }

    /**
     * 获取创建人
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_author_uid'])->alias('creator');
    }
}
