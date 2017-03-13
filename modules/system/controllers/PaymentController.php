<?php

namespace app\modules\system\controllers;
use app\controllers\GController;
use app\modules\task\models\TaskPayInfo;
use app\modules\task\models\TaskPayInfoSearch;
use Yii;
use yii\web\NotFoundHttpException;

class PaymentController extends GController
{
    public function actionIndex()
    {
        $searchModel = new TaskPayInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = TaskPayInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
