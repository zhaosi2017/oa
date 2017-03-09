<?php

namespace app\modules\task\controllers;

use app\modules\product\models\ProductCategory;
use app\modules\system\models\Notice;
use app\modules\task\models\TaskDealPrice;
use app\modules\task\models\TaskExecuteInfo;
use Yii;
use app\modules\task\models\Task;
use app\modules\task\models\TaskSearch;
use app\modules\task\models\ProductSearch;
use app\controllers\GController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends GController
{

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSentIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sent-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('wait-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReceivedIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('received-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSentTrash()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sent-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSentDetail($id)
    {
        $model = $this->findModel($id);
        return $this->render('sent-detail', [
            'model' => $model,
            'children' => $model->getChildren($id),
        ]);
    }

    public function actionWaitDetail($id)
    {
        $model = $this->findModel($id);
        return $this->render('wait-detail', [
            'model' => $model,
            'children' => $model->getChildren($id),
        ]);
    }

    public function actionReceivedDetail($id)
    {
        $model = $this->findModel($id);
        return $this->render('received-detail', [
            'model' => $model,
            'children' => $model->getChildren($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model->file =  UploadedFile::getInstance($model, 'file');
            if($model->file){   //文件上传大小限制 10M
                $randName = uniqid() . rand(1000, 9999) . "." . $model->file->extension;
                $model->attachment = $randName;
                //$model->attachment = $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs(Yii::$app->params['uploadPath'] . $randName);
                $model->file = null;
            }

            $task_deal_price_model = new TaskDealPrice();

            $model->save();
            if(Yii::$app->request->post('PurchasePrice') && Yii::$app->request->post('TaskDealPrice')){
                $purchasePrice = Yii::$app->request->post('PurchasePrice');
                $taskDealPrice = Yii::$app->request->post('TaskDealPrice');
                foreach ($taskDealPrice as $k=>$v){
                    $_task_deal_price_model = clone $task_deal_price_model;
                    $_task_deal_price_model->task_id = $model->id;
                    $_task_deal_price_model->product_id = $model->product_id;
                    $_task_deal_price_model->money_id = $k;
                    $_task_deal_price_model->price = $v;
                    $_task_deal_price_model->purchase_price = $purchasePrice[$k];
                    $_task_deal_price_model->save();
                }
            }
            $model->sendSuccess();

            return $this->redirect(['sent-index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateChild()
    {
        $model = new Task();

        $url = Yii::$app->request->referrer;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->file =  UploadedFile::getInstance($model, 'file');
            if($model->file){   //文件上传大小限制 10M
                $randName = uniqid() . rand(1000, 9999) . "." . $model->file->extension;
                $model->attachment = $randName;
                //$model->attachment = $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs(Yii::$app->params['uploadPath'] . $randName);
                $model->file = null;
            }

            $task_deal_price_model = new TaskDealPrice();

            $model->save();
            if(Yii::$app->request->post('PurchasePrice') && Yii::$app->request->post('TaskDealPrice')){
                $purchasePrice = Yii::$app->request->post('PurchasePrice');
                $taskDealPrice = Yii::$app->request->post('TaskDealPrice');
                foreach ($taskDealPrice as $k=>$v){
                    $_task_deal_price_model = clone $task_deal_price_model;
                    $_task_deal_price_model->task_id = $model->id;
                    $_task_deal_price_model->product_id = $model->product_id;
                    $_task_deal_price_model->money_id = $k;
                    $_task_deal_price_model->price = $v;
                    $_task_deal_price_model->purchase_price = $purchasePrice[$k];
                    $_task_deal_price_model->save();
                }
            }
            $model->sendSuccess();
            return $this->redirect($url);
        } else {
            return $this->render('create-child', [
                'model' => $model,
            ]);
        }
    }

    public function actionReceivedFeedback()
    {
        $this->layout = '@app/views/layouts/form';
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('received-feedback', [
                'model' => $model,
            ]);
        }
    }

    public function actionReceivedHandle()
    {
        $this->layout = '@app/views/layouts/form';
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('received-handle', [
                'model' => $model,
            ]);
        }
    }

    public function actionReceive()
    {
        $model = new TaskExecuteInfo();
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $task_model = Task::findOne($model->task_id);
            $task_model->status = 4;
            $task_model->execute_company_id = $model->company_id;
            $task_model->update();
            //todo 发送通知
            $model->sendSuccess();
            $this->redirect(['wait-index']);
        }
        return false;
    }

    /**
     * Updates an existing Task model.
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
     * Deletes an existing Task model.
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

    public function actionCustomer()
    {
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $identity = (Object) Yii::$app->user->identity;
            $company_id = $identity->company_id;
            $model = ["" => '--请选择客户--'];
            switch (Yii::$app->request->post('customer_category')){
                case 1:
                    $model += Task::find()->customerDownList($company_id);
                    break;
                case 2:
                    $model += Task::find()->getRatedCompany($company_id);
                    break;
            }
            foreach($model as $value=>$name)
            {
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
        return false;
    }

    public function actionGrade()
    {
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $identity = (Object) Yii::$app->user->identity;

            $grade = 0;

            $customer_category = Yii::$app->request->post('customer_category');
            $company_customer_id = Yii::$app->request->post('company_customer_id');
            $company_id = $identity->company_id;

            $grade += Task::find()->getGrade($customer_category, $company_customer_id, $company_id);
            return $grade;
        }
        return false;
    }

    public function actionSecondCategory()
    {
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $first_category_id = Yii::$app->request->post('first_category_id');
            $model = ["" => '--产品二级分类--'] + ProductCategory::find()->getChildren($first_category_id);
            foreach($model as $value=>$name)
            {
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
        return false;
    }

    public function actionProductSearch()
    {
        $this->layout = '@app/views/layouts/list';
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('product-search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProductTree()
    {
        $this->layout = '@app/views/layouts/list';
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('product-tree', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRelease($task_id)
    {
        if(Yii::$app->request->isPost){
            $model = Task::findOne($task_id);
            $model->status = 3;
            if($model->update()){
                $notice_model = new Notice();
                $notice_model->notify($model);
                $model->sendSuccess();
                $this->redirect(['wait-index']);
            }
        }
        return false;
    }

    public function actionDownload($attachment)
    {
        $path = Yii::$app->params['uploadPath'] . $attachment;
        return Yii::$app->response->sendFile($path);
    }
}
