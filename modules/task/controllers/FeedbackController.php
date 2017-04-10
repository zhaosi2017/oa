<?php

namespace app\modules\task\controllers;

use app\modules\system\models\Notice;
use app\modules\task\models\Task;
use app\modules\task\models\TaskCollectionInfo;
use app\modules\task\models\TaskPayInfo;
use Yii;
use app\modules\task\models\TaskFeedback;
use app\modules\task\models\TaskFeedbackSearch;
use app\controllers\GController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * FeedbackController implements the CRUD actions for TaskFeedback model.
 */
class FeedbackController extends GController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['entry'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
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

    public function actionExecute()
    {
        $model = new TaskFeedback();
        $model_post = $model->load(Yii::$app->request->post());
        if(!empty($model_post)) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {   //文件上传大小限制 10M
                $randName = uniqid() . rand(1000, 9999) . "." . $model->file->extension;
                $model->attachment = $randName;
                $model->file->saveAs(Yii::$app->params['uploadPath'] . $randName);
                $model->file = null;
            }

            if ($model->type == 4) {
                if (TaskCollectionInfo::findOne(['task_id' => $model->task_id, 'type' => 0])) {
                    $model->sendError('收款单还处于“待收款”状态，不能完成任务！');
                    return $this->redirect(['index', 'id' => $model->task_id]);
                }
            }

            if ($model_post && $model->save()) {
                $task_model = Task::findOne($model->task_id);
                $task_status = Yii::$app->request->post('TaskStatus');
                $task_status && $task_model->status = $task_status;
                $model->type != 0 && $task_model->update();

                if ($model->type == 3) {
                    //当任务客户不等于任务产品所属公司时，需要自动生成收款单
                    if ( $task_model->customer_category == 1
                        || ($task_model->customer_category == 2 && $task_model['group']['id'] != $task_model['product']['company_id'])
                    ) {
                        $collection = new TaskCollectionInfo();
                        $collection->task_id = $model->task_id;
                        $collection->company_id = $task_model['product']['company_id'];
                        $collection->customer_category = $task_model->customer_category;
                        $collection->company_customer_id = $task_model->company_customer_id;
                        $collection->save();
                    }
                    //生成付款单
                    $pay_model = new TaskPayInfo();
                    $pay_model->task_id = $model->task_id;
                    $pay_model->status = 2; //已付款
                    $pay_model->pay_company_id = $task_model['product']['company_id'];
                    $pay_model->execute_company_id = $task_model['executeInfo']['company_id'];
                    $pay_model->save();
                }
                $model->sendSuccess();
                $notice_model = new Notice();
                !empty($task_model['executeInfo']['user']) && $notice_model->notify($task_model);
                return $this->redirect(['index', 'id' => $model->task_id]);
            }
        }
        return false;
    }

    public function actionExecuteReceived()
    {
        $model = new TaskFeedback();

        if($model->load(Yii::$app->request->post())){
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {   //文件上传大小限制 10M
                $randName = uniqid() . rand(1000, 9999) . "." . $model->file->extension;
                $model->attachment = $randName;
                $model->file->saveAs(Yii::$app->params['uploadPath'] . $randName);
                $model->file = null;
            }

            $model->save();
            $task_model = Task::findOne($model->task_id);
            $task_status = Yii::$app->request->post('TaskStatus');
            $task_status && $task_model->status = $task_status;
            $task_model->update();
            $model->sendSuccess();
            $notice_model = new Notice();
            !empty($task_model['executeInfo']['user']) && $notice_model->notify($task_model);
            return $this->redirect(['index-received','id'=>$model->task_id]);
        }
        return false;
    }

    /**
     * @param $id
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionIndexReceived($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('index-received', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionTrash($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionTrashReceived($id)
    {
        $searchModel = new TaskFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Task::findOne($id);
        return $this->render('index-received', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskFeedback model.
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
     * Creates a new TaskFeedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskFeedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskFeedback model.
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
     * Deletes an existing TaskFeedback model.
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
     * Finds the TaskFeedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskFeedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskFeedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
