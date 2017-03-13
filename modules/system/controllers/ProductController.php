<?php

namespace app\modules\system\controllers;

use app\controllers\GController;
use app\modules\product\models\Product;
use app\modules\product\models\ProductExecutePrice;
use app\modules\product\models\ProductPurchasePrice;
use app\modules\product\models\ProductSearch;
use app\modules\user\models\Company;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class ProductController extends GController
{
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionPrice($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $posts = Yii::$app->request->post();
            $purchase_model = new ProductPurchasePrice();
            $execute_model = new ProductExecutePrice();
            ProductPurchasePrice::deleteAll(['product_id'=>$posts['product-id']]);
            ProductExecutePrice::deleteAll(['product_id'=>$posts['product-id']]);
            //事务开始
            $transaction=Yii::$app->db->beginTransaction();
            try{
                if(!empty($posts['ProductPurchasePrice'])){
                    foreach ($posts['ProductPurchasePrice'] as $money_id => $v){
                        $_purchase_model = clone $purchase_model;
                        $_purchase_model->product_id = $posts['product-id'];
                        $_purchase_model->money_id = $money_id;
                        $_purchase_model->setAttributes($v);
                        $_purchase_model->save();
                    }
                }

                if(!empty($posts['ProductExecutePrice'])){
                    foreach ($posts['ProductExecutePrice'] as $cid => $price){
                        $_execute_model = clone $execute_model;
                        $_execute_model->product_id = $posts['product-id'];
                        $_execute_model->money_id = $posts['preset-currency'];
                        $_execute_model->company_id = $cid;
                        $_execute_model->price = $price['price'];
                        $_execute_model->save();
                    }
                }
                $transaction->commit();
                $model->sendSuccess();
            } catch (Exception $e){
                $model->sendError();
                $transaction->rollBack();
            }

            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            $identity = (Object) Yii::$app->user->identity;
            $company_id = $identity->company_id;
            $company = new Company();
            //获取公司列表
            $companyList = $company->getChildren($company_id);
            return $this->render('price_form', [
                'model' => $model,
                'company' => $companyList,
            ]);
        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
