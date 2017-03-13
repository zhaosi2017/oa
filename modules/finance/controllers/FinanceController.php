<?php

namespace app\modules\finance\controllers;
use app\controllers\GController;
use app\modules\system\models\MoneySearch;

class FinanceController extends GController
{
    public function actionSummary()
    {
        $searchModel = new MoneySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $gets = \Yii::$app->request->get('MoneySearch');
        if(!empty($gets)){
            $gets['start_date'] > $gets['end_date'] && $searchModel->sendError('起始日期必须小于终止日期');
        }else{
            $dataProvider = null;
        }

        return $this->render('summary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
