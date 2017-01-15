<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use Yii;
use app\modules\user\models\Posts;
use app\modules\user\models\PostsSearch;
use app\controllers\GController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends GController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
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
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '新增岗位成功');
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '修改岗位成功');
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAuth($id)
    {
        $this->layout = '@app/views/layouts/form';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $posts = Yii::$app->request->post();
            if(isset($posts['Auth'])){
                $auth = Yii::$app->authManager;
                $role = false;
                foreach ($posts['Auth'] as $permission){
                    //添加权限
                    $permissionData = $auth->createPermission($permission);
                    $permissionData->description = 'permission: '.$permission;
                    $auth->add($permissionData);

                    //添加角色并赋于权限 //todo 可以放在循环外
                    if($role===false){
                        $role = $auth->createRole($model->id);
                        $auth->add($role);
                    }

                    $auth->addChild($role, $permissionData);
                }

                if($role!==false){
                    $users = User::find()->select(['id'])->where(['status'=>0,'posts_id'=>$model->id])->column();
                    //为用户指派角色 ／／todo 这一步放在添加用户的时候做
                    foreach ($users as $userId){
                        $auth->assign($role, $userId);
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', '权限设置成功');
            return $this->redirect(['auth', 'id' => $model->id]);
        } else {
            return $this->render('auth', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Posts model.
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
            Yii::$app->getSession()->setFlash('success', '操作成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '操作失败');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
