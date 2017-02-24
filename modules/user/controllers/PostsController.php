<?php

namespace app\modules\user\controllers;

//use app\modules\user\models\User;
use app\modules\user\models\Department;
use Yii;
use app\modules\user\models\Posts;
use app\modules\user\models\PostsSearch;
use app\controllers\GController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends GController
{

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

    /**
     * @return string
     */
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
     * @return bool
     */
    public function actionDepartment()
    {
        if(Yii::$app->request->isPost){
            $company_id = Yii::$app->request->post('company_id');
            $model = ["" => '--请选择--'] + Department::find()->downList($company_id);
            foreach($model as $value=>$name)
            {
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
        return false;
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

            //创建角色
            $auth = Yii::$app->authManager;
            //添加角色[岗位编号对应岗位这类角色]
            $role = $auth->createRole($model->id);
            $role->description = '岗位编号-' . $model->id;
            $auth->add($role);

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
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $posts = Yii::$app->request->post();
            if(isset($posts['Auth'])){

                //创建许可，给角色分配许可，并创建它们的层次关系
                $auth = Yii::$app->authManager;
                $role = $auth->createRole($model->id);

                //如果获取不到角色就添加角色
                $role->description = '岗位编号:' . $model->id;
                $auth->getRole($model->id) || $auth->add($role) ;

                //重新分配许可
                empty($auth->getChildren($model->id)) || $auth->removeChildren($role);

                foreach ($posts['Auth'] as $permission){
                    //添加权限
                    $permissionData = $auth->createPermission($permission);
                    $permissionData->description = 'permission: '.$permission;

                    //如果能获取到许可就不再添加许可
                    $auth->getPermission($permission) || $auth->add($permissionData);

                    $auth->addChild($role, $permissionData);
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
