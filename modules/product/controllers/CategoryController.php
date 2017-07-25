<?php

namespace app\modules\product\controllers;

use Yii;
use app\modules\product\models\RootCategory;
use app\modules\product\models\RootCategorySearch;
use app\controllers\GController;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for RootCategory model.
 */
class CategoryController extends GController
{
    public function actionRootSet()
    {
        $model = new RootCategory();

        $identify = (Object) Yii::$app->user->identity;
        $root_category = RootCategory::findOne(['company_id' => $identify->company_id]);
        if($root_category){
            $model = $root_category;
            /*$check_array = [
                $model->visible & 8,
                $model->visible & 4,
                $model->visible & 2,
                $model->visible & 1,
            ];
            $model->visible = $check_array;*/
        }

        if($model->load(Yii::$app->request->post())){
            /*$visible = (array)$model->visible;
            $model->visible = array_sum($visible);*/
            if($model->save()){
                $model->sendSuccess();
//                $model->visible = !empty($visible) ? $visible : false;
                $model->name = Yii::$app->security->decryptByKey(base64_decode($model->name), Yii::$app->params['inputKey']);
            }else{
                $model->sendError();
            }
        }
        return $this->render('root-set',[
            'model' => $model,
        ]);
    }

    /**
     * Lists all RootCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RootCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new RootCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RootCategory model.
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
     * Creates a new RootCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RootCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RootCategory model.
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
     * Deletes an existing RootCategory model.
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
     * Finds the RootCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RootCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RootCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
