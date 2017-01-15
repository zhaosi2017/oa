<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CActiveRecord extends ActiveRecord
{

    public function ajaxResponse($response = ['code'=>0, 'msg'=>'操作成功', 'data'=>[]])
    {
        header('Content-Type: application/json');
        exit(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    public function changeStatus($status, $condition='')
    {
        $params = ['status' => $status];
        return $this::getDb()->createCommand()->update($this::tableName(), $params, $condition)->execute();
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
            }else{
                $this->update_author_uid = $uid;
                $this->update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            }
            return true;
        }
        return false;
    }

    public function sendSuccess($str='操作成功')
    {
        Yii::$app->getSession()->setFlash('success', $str);
    }

    public function sendError($str='操作失败')
    {
        Yii::$app->getSession()->setFlash('error', $str);
    }

}