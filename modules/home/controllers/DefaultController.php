<?php

namespace app\modules\home\controllers;

use app\controllers\GController;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Default controller for the `home` module
 */
class DefaultController extends GController
{
//    public $layout = '@app/views/layouts/public';

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
        $this->layout = '@app/views/layouts/right';
        return $this->render('index');
    }
}
