<?php

namespace app\modules\home\controllers;

use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `home` module
 */
class DefaultController extends Controller
{
    public $layout = '@app/views/layouts/public';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['entry'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
                'denyCallback' => function () { //have two params $rule , $action
                    return $this->redirect(Url::to(['/login/default/entry']));
                },
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
