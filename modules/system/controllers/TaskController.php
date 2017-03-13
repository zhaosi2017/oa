<?php

namespace app\modules\system\controllers;

use app\controllers\GController;
use app\modules\task\models\Task;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskFeedbackSearch;
use app\modules\task\models\TaskPayInfo;
use app\modules\task\models\TaskRemarkSearch;
use app\modules\task\models\TaskSearch;
use Yii;
use yii\web\NotFoundHttpException;

class TaskController extends GController
{
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'children' => $model->getChildren($id),
        ]);
    }

    public function actionFeedback($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('feedback', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFeedbackTrash($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('feedback', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPayReceiptInfo($id)
    {
        $model = Task::findOne($id);
        $collection = TaskCollectionInfo::findAll(['task_id' => $id,'status'=>0]);
        $pay_model = TaskPayInfo::findAll(['task_id' => $id, 'status'=>0]);
        return $this->render('pay-receipt-info',[
            'model' => $model,
            'collection' => $collection,
            'pay_model' => $pay_model,
        ]);
    }

    public function actionRemark($id)
    {
        $searchModel = new TaskRemarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('remark', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRemarkTrash($id)
    {
        $searchModel = new TaskRemarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('remark', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
