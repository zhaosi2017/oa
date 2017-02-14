<?php

namespace app\modules\home\controllers;

use app\controllers\GController;

/**
 * Default controller for the `home` module
 */
class MainController extends GController
{

//    public $layout = '@app/views/layouts/iframe';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDeny()
    {
        return $this->render('deny');
    }
}
