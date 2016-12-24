<?php

namespace app\modules\user\controllers;

use app\controllers\GController;

/**
 * Default controller for the `user` module
 */
class DefaultController extends GController
{
    public function actionPassword()
    {
        return $this->render('password');
    }
}
