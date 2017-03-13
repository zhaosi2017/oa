<?php

namespace app\modules\system\controllers;

use app\controllers\GController;
use app\modules\customer\models\GroupRate;
use app\modules\user\models\Company;

class GroupController extends GController
{
    public function actionRate()
    {
        $model = GroupRate::find()
            ->select(['grade','CONCAT(company_id,"-",rate_company_id) AS company_key'])
            ->indexBy('company_key')->column();

        $company = Company::find()->select(['id','name'])->where(['status'=>0])->asArray()->all();
        return $this->render('rate',['model'=>$model,'company'=>$company]);
    }

}
