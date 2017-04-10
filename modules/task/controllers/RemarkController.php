<?php

namespace app\modules\task\controllers;

use app\modules\task\models\Task;
use Yii;
use app\modules\task\models\TaskRemark;
use app\modules\task\models\TaskRemarkSearch;
use app\controllers\GController;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * RemarkController implements the CRUD actions for TaskRemark model.
 */
class RemarkController extends GController
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
                        'actions' => ['index','create','trash','switch'],
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
        $searchModel = new TaskRemarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        $remark_model = new TaskRemark();
        return $this->render('index', [
            'model' => $model,
            'remark_model' => $remark_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash($id)
    {
        $searchModel = new TaskRemarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskRemark model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TaskRemark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskRemark();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->task_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskRemark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaskRemark model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $status
     * @return \yii\web\Response
     */
    public function actionSwitch($id, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;
        if($model->save()){
            $model->sendSuccess();
        }else{
            $model->sendError();
        }
        return $this->redirect(['index', 'id'=>$model->task_id]);
    }

    /**
     * Finds the TaskRemark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskRemark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskRemark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
