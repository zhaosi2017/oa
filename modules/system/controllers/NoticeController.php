<?php

namespace app\modules\system\controllers;

use app\modules\system\models\NoticeQueueUser;
use Yii;
use app\modules\system\models\Notice;
use app\modules\system\models\NoticeSearch;
use app\controllers\GController;
use yii\web\NotFoundHttpException;

/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends GController
{
    /**
     * Lists all Notice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserIndex()
    {
        $searchModel = new NoticeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('user-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notice model.
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
     * Creates a new Notice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notice model.
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
     * Deletes an existing Notice model.
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
     * Finds the Notice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetPushData()
    {
        $model = Notice::find();
        $res = $model->select(['recipient_uid','id'])->where(['status'=>0])->asArray()->all();
        $queueUser = NoticeQueueUser::find()->select(['id','uid'])->indexBy('uid')->column();
        $user_count = [];
        if(!empty($res)){
            foreach ($res as $item){
                $recipient_uid = explode(',', $item['recipient_uid']);
                $user_count = array_merge($user_count, $recipient_uid);
            }
            $user_count = array_count_values($user_count);
        }
        return json_encode($user_count + ['q'=>$queueUser]);
    }

    public function actionUserRead()
    {
        if(Yii::$app->request->isAjax){
            $ids = Yii::$app->request->post('ids');
            if(!empty($ids)){
                return Notice::updateAll([
                    'status'=>1,
                    'read_time'=> date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']),
                ],['in','id',$ids]);
            }
        }
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->get('id');
            $model = Notice::findOne($id);
            $model->status = 1;
            $model->read_time = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
            $model->update();
            $this->redirect(['/system/notice/user-index']);
        }
        return false;
    }

    public function actionRead()
    {
        if(Yii::$app->request->isAjax){
            $ids = Yii::$app->request->post('ids');
            if(!empty($ids)){
                return Notice::updateAll([
                    'status'=>1,
                    'read_time'=> date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']),
                ],['in','id',$ids]);
            }
        }
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->get('id');
            $model = Notice::findOne($id);
            $model->status = 1;
            $model->read_time = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
            $model->save();
            $this->redirect(['/system/notice/index']);
        }
        return false;
    }

    public function actionReceived()
    {
        if(Yii::$app->request->isAjax){
            $uid = Yii::$app->request->post('uid');
            return NoticeQueueUser::deleteAll(['uid'=>$uid]);
        }
        return false;
    }
}
