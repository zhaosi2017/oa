<?php

namespace app\modules\product\controllers;

use app\modules\product\models\RootCategory;
use Yii;
use app\modules\product\models\ProductCategory;
use app\modules\product\models\ProductCategorySearch;
use app\controllers\GController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends GController
{
    /**
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionTrash()
    {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCategory model.
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
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $identity = (object) Yii::$app->user->identity;
        $root_category = RootCategory::findOne(['company_id' => $identity->company_id]);

        if(!$root_category){
            return '请先创建根分类';
        }else{
            $model = new ProductCategory();
            if ($model->load(Yii::$app->request->post())) {
                $visible = (array)$model->avisible;
                $model->avisible = array_sum($visible);
                if($model->save()){
                    $model->sendSuccess();
                    $model->avisible = !empty($visible) ? $visible : false;
                }else{
                    $model->sendError();
                }
                return $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $visible = (array)$model->avisible;
            $model->avisible = array_sum($visible);
            if($model->save()){
                $model->sendSuccess();
            }else{
                $model->sendError();
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            $visible = [
                $model->avisible & 8,
                $model->avisible & 4,
                $model->avisible & 2,
                $model->avisible & 1,
            ];
            $model->avisible = $visible;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductCategory model.
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
        if($status == 1){

        }
        $model->status = $status;
        if($model->save()){
            Yii::$app->getSession()->setFlash('success', '操作成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '操作失败');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetSecondCategory()
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
}
