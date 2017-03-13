<?php

namespace app\modules\task\controllers;

use app\modules\task\models\Task;
use app\controllers\GController;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskPayInfo;
use yii\filters\AccessControl;
use yii\helpers\Url;

class PayController extends GController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['entry'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','index-received'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
                'denyCallback' => function () { //have two params $rule , $action
                    return $this->redirect(Url::to(['/login/default/entry']));
                },
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionIndex($id)
    {
        $model = Task::findOne($id);
        $collection = TaskCollectionInfo::findAll(['task_id' => $id]);
        $pay_model = TaskPayInfo::findAll(['task_id' => $id]);
        return $this->render('index',[
            'model' => $model,
            'collection' => $collection,
            'pay_model' => $pay_model,
        ]);
    }

    public function actionIndexReceived($id)
    {
        $model = Task::findOne($id);
        $collection = TaskCollectionInfo::findAll(['task_id' => $id]);
        $pay_model = TaskPayInfo::findAll(['task_id' => $id]);
        return $this->render('index-received',[
            'model' => $model,
            'collection' => $collection,
            'pay_model' => $pay_model,
        ]);
    }

}
