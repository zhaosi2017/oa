<?php

namespace app\modules\task\models;

use app\modules\user\models\Company;
use app\modules\user\models\User;
use app\models\CActiveRecord;

/**
 * This is the model class for table "task_remark".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $content
 * @property integer $create_author_uid
 * @property integer $update_author_uid
 * @property string $create_time
 * @property string $update_time
 * @property integer $type
 * @property integer $status
 */
class TaskRemark extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_remark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'create_author_uid', 'update_author_uid', 'type', 'status'], 'integer'],
            [['content'], 'string'],
            [['create_time'], 'safe'],
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
            'create_author_uid' => 'Create Author Uid',
            'create_time' => 'Create Time',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskRemarkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskRemarkQuery(get_called_class());
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
     * 获取所在公司
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->alias('company');
    }

}
