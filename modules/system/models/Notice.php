<?php

namespace app\modules\system\models;

use Yii;
use app\models\CActiveRecord;

/**
 * This is the model class for table "notice".
 *
 * @property integer $id
 * @property integer $status
 * @property string $title
 * @property string $content
 * @property string $recipient_uid
 * @property integer $sender_uid
 * @property string $receive_time
 * @property string $send_time
 * @property string $read_time
 */
class Notice extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sender_uid'], 'integer'],
            [['content', 'recipient_uid'], 'string'],
            [['receive_time', 'send_time', 'read_time'], 'safe'],
            [['title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '状态',
            'title' => '标题',
            'content' => '内容',
            'recipient_uid' => 'Recipient Uid',
            'sender_uid' => 'Sender Uid',
            'receive_time' => 'Receive Time',
            'send_time' => 'Send Time',
            'read_time' => '阅读时间',
        ];
    }

    /**
     * @inheritdoc
     * @return NoticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoticeQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->title = Yii::$app->security->decryptByKey(base64_decode($this->title), Yii::$app->params['inputKey']);
        $this->content = Yii::$app->security->decryptByKey(base64_decode($this->content), Yii::$app->params['inputKey']);
    }

    public function getStatuses()
    {
        return [
            0 => '未读',
            1 => '已读',
        ];
    }

    public function beforeSave($insert)
    {
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if ($this->isNewRecord) {
            $this->sender_uid = $uid;
            $this->send_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            $this->title = base64_encode(Yii::$app->security->encryptByKey($this->title,Yii::$app->params['inputKey']));
            $this->content = base64_encode(Yii::$app->security->encryptByKey($this->content,Yii::$app->params['inputKey']));
        }else{
            $this->send_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            $this->title = base64_encode(Yii::$app->security->encryptByKey($this->title,Yii::$app->params['inputKey']));
            $this->content = base64_encode(Yii::$app->security->encryptByKey($this->content,Yii::$app->params['inputKey']));
        }
        return true;
    }

    public function getIdentity()
    {
        return (Object) Yii::$app->user->identity;
    }

    public function notify($task_model)
    {
        $auth = Yii::$app->authManager;
        $users = '';
        $queueUsers = [];
        switch ($task_model->status){
            case 3:
                $this->title = '新任务已发布';
                $this->content = '系统中有一个新发布的任务('.$task_model->number.')，请尽快处理！';
                if(empty($task_model['productExecuteUser'])){
                    return false;
                }
                //发送系统通知和邮件给任务关联产品的执行公司中，拥有“待接收任务”页面进入权限的用户！
                foreach ($task_model['productExecuteUser'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/sent-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;
            case 4:
                $this->title = '任务已接收';
                $this->content = '任务('.$task_model->number.')已被接收，请注意查看！';
                //发送系统通知和邮件给任务所属公司中，拥有“已发任务”页面进入权限的用户！
                foreach ($task_model['company']['userIds'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/sent-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;
            case 5:
                $this->title = '任务待验收';
                $this->content = '任务('.$task_model->number.')待验收，请注意查看！';
                //发送系统通知和邮件给任务所属公司中，拥有“已发任务”页面进入权限的用户！
                foreach ($task_model['company']['userIds'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/sent-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;
            case 6:
                $this->title = '任务已验收';
                $this->content = '任务('.$task_model->number.')已验收，请注意查看！';
                //发送系统通知和邮件给任务执行公司中的用户,拥有“已接收任务”页面进入权限的用户！
                foreach ($task_model['executeInfo']['user'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/received-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;
            case 8:
                $this->title = '任务撤销';
                $this->content = '任务('.$task_model->number.')已被撤销，请注意查看！';
                //发送系统通知和邮件给任务执行公司中的用户,拥有“已接收任务”页面进入权限的用户！
                foreach ($task_model['executeInfo']['user'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/received-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;

            case 10:
                $this->title = '任务验收不通过';
                $this->content = '任务('.$task_model->number.')验收不通过，需要继续处理，请注意查看！';
                //发送系统通知和邮件给任务执行公司中的用户,拥有“已接收任务”页面进入权限的用户！
                foreach ($task_model['executeInfo']['user'] as $item){
                    if($auth->checkAccess($item['id'],'task/task/received-index')){
                        $users .= $item['id'].',' ;
                        $queueUsers[] = [$item['id']];
                    }
                }
                break;
        }

        $this->recipient_uid = $users;
        $this->insert();
        // 保存消息队列接收用户
        Yii::$app->db->createCommand()->batchInsert(NoticeQueueUser::tableName(),['uid'],$queueUsers)->execute();
        return false;
    }

}
