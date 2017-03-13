<?php

namespace app\modules\system\controllers;
use app\controllers\GController;
use app\modules\product\models\RootCategory;
use app\modules\product\models\RootCategorySearch;
use Yii;

class RootCategoryController extends GController
{
    public function actionIndex()
    {
        $searchModel = new RootCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSet($id)
    {
        $model = new RootCategory();

        $root_category = RootCategory::findOne($id);
        if($root_category){
            $model = $root_category;
            $check_array = [
                $model->visible & 8,
                $model->visible & 4,
                $model->visible & 2,
                $model->visible & 1,
            ];
            $model->visible = $check_array;
        }

        if($model->load(Yii::$app->request->post())){
            $visible = (array)$model->visible;
            $model->visible = array_sum($visible);
            if($model->save()){
                $model->sendSuccess();
                $model->visible = !empty($visible) ? $visible : false;
            }else{
                $model->sendError();
            }
        }
        return $this->render('set',[
            'model' => $model,
        ]);
    }

}
