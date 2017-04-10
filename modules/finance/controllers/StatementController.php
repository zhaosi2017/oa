<?php

namespace app\modules\finance\controllers;

use app\modules\finance\models\FinanceSubject;
use app\modules\task\models\Task;
use app\modules\user\models\Company;
use Yii;
use app\modules\finance\models\Statement;
use app\modules\finance\models\StatementSearch;
use app\controllers\GController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * StatementController implements the CRUD actions for Statement model.
 */
class StatementController extends GController
{
    /**
     * Lists all Statement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Statement model.
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
     * Creates a new Statement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Statement();

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
     * Updates an existing Statement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->sendSuccess();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Statement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSwitch($id, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;
        if($model->save()){
            Yii::$app->getSession()->setFlash('success', '操作成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '操作失败');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Statement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Statement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Statement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetSecondSubject()
    {
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $first_subject_id = Yii::$app->request->post('first_subject_id');
            $model = ["" => '二级科目'];
            if($first_subject_id>0){
                $model += FinanceSubject::find()
                        ->select(['subject_name','id'])
                        ->where(['superior_subject_id'=>$first_subject_id,'status'=>0])
                        ->indexBy('id')
                        ->column();
            }
            foreach($model as $value=>$name)
            {
                $name = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
        return null;
    }

    public function actionGetCompanyTask()
    {
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $type = Yii::$app->request->post('type');
            $model = ["" => '请选择关联公司/任务'];
            if($type==1){
                $model += Company::find()
                    ->select(['name','id'])
                    ->where(['status'=>0])
                    ->indexBy('id')
                    ->column();
            }
            if($type==2){
                $identity = (Object) Yii::$app->user->identity;
                $model += Task::find()
                    ->select(['name','id'])
                    ->where(['company_id'=>$identity->company_id])
                    ->andWhere(['status'=>6])
                    ->orWhere(['status'=>7])
                    ->indexBy('id')
                    ->column();
            }
            foreach($model as $value=>$name)
            {
                $value && $name = Yii::$app->security->decryptByKey(base64_decode($name),Yii::$app->params['inputKey']);
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
        return null;
    }
}
