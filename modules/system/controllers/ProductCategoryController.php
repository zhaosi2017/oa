<?php

namespace app\modules\system\controllers;
use app\controllers\GController;
use app\modules\product\models\ProductCategory;
use app\modules\product\models\ProductCategorySearch;
use Yii;
use yii\web\NotFoundHttpException;

class ProductCategoryController extends GController
{
    public function actionIndex()
    {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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
}
