<?php

namespace app\modules\user\controllers;

use app\controllers\GController;
use app\modules\user\models\PasswordForm;
use Yii;
/**
 * Default controller for the `user` module
 */
class DefaultController extends GController
{
    public function actionPassword()
    {
        $this->layout = '@app/views/layouts/form';
        $model = new PasswordForm();
        if($model->load(Yii::$app->request->post()) && $model->updateSave()){
            Yii::$app->getSession()->setFlash('success', '密码修改成功');
        }
        return $this->render('password',['model' => $model]);
    }
}
