<?php

namespace app\modules\product\controllers;

use app\modules\product\models\ProductExecutePrice;
use app\modules\product\models\ProductPurchasePrice;
use app\modules\user\models\Company;
use Yii;
use app\modules\product\models\Product;
use app\modules\product\models\ProductSearch;
use app\controllers\GController;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
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
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->sendSuccess();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
     * Deletes an existing Product model.
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
