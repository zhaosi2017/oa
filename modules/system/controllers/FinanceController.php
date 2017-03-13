<?php

namespace app\modules\system\controllers;

use app\controllers\GController;
use app\modules\system\models\Money;
use app\modules\user\models\Company;

class FinanceController extends GController
{
    public function actionSummary()
    {
        $query = Company::find();

        $model = $query->where(['status'=>0])->all();
        $money = Money::find()->where(['status'=>0])->asArray()->all();

        return $this->render('summary', [
            'model' => $model,
            'money' => $money,
        ]);
    }

}
