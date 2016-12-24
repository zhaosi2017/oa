<?php

namespace app\modules\home\controllers;

use app\controllers\PController;

/**
 * Default controller for the `home` module
 */
class DefaultController extends PController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
