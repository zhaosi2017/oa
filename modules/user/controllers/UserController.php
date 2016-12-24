<?php

namespace app\modules\user\controllers;

use app\modules\user\models\LoginLogs;
use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\controllers\GController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends GController
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchTrash(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '新增用户成功');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '操作成功');
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPermission($id)
    {
        $this->layout = '@app/views/layouts/form';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $posts = Yii::$app->request->post();

            if($posts['unlock']){
                $loginLog = LoginLogs::find()->where(['uid' => $model->id])->orderBy(['id'=>SORT_DESC])->one();
                $loginLog->status = 1;
                $loginLog->save();
            }

            if($model->email){
                if(User::findOne(['id'=>'!='.$model->id,'email'=>$model->email . $posts['email-postfix']])){
                    Yii::$app->getSession()->setFlash('error', '该邮箱已被占用');
                    return $this->redirect(['index', 'id' => $model->id]);
                }else{
                    $model->email = $model->email . $posts['email-postfix'];
                }
            }

            if($model->password){ //如果勾选中就生成密码保存
                $password = $model->password[0];
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($password);
            }

            if($model->save()){
                Yii::$app->getSession()->setFlash('success', '操作成功');
            }else{
                Yii::$app->getSession()->setFlash('error', '操作失败');
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            $model->password = uniqid().rand(10,99);
            return $this->render('permission', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
