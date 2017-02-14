<?php

namespace app\modules\customer\controllers;

use app\controllers\GController;
use app\modules\customer\models\GroupRate;
use app\modules\user\models\Company;
use app\modules\user\models\User;
use Yii;

class GroupController extends GController
{
    public function actionRate()
    {
        $identity = (Object) Yii::$app->user->identity;
        if(Yii::$app->request->post()){
            $posts = Yii::$app->request->post();
            $model = new GroupRate();

            GroupRate::deleteAll(['rate_company_id'=>$identity->company_id]);
            $flag = true;
            foreach ($posts as $item){
                if(is_array($item) && isset($item['grade'])){
                    $add_model = clone $model;
                    $add_model->company_id = $item['id'];
                    $add_model->grade = $item['grade'];
                    $add_model->rater_uid = Yii::$app->user->id;
                    $flag = $add_model->save() && $flag;
                }
            }

            $flag && Yii::$app->getSession()->setFlash('success', '操作成功');

        }

        $company = Company::find()->select(['updater.account','company.id','company.name','company.update_author_uid','company.update_time'])->joinWith('updater')->where(['company.status'=>0])->all();
        $groupRate = GroupRate::find()->select(['grade','company_id'])->where(['rate_company_id'=>$identity->company_id])->indexBy('company_id')->column();
        return $this->render('rate',[
            'groupRate' => $groupRate,
            'company' => $company,
        ]);
    }

    public function actionUpdate()
    {
        $company = Company::find()->select(['name','update_author_uid','update_time'])->where(['status'=>0])->all();
        $users = User::find()->select(['account','id'])->indexBy('id')->column() + [ 0=>'管理员'];
        $identity = (Object) Yii::$app->user->identity;
        $model = GroupRate::find()->select(['grade','company_id'])->where(['rate_company_id'=>$identity->company_id])->indexBy('company_id')->column();
        return $this->render('update',[
            'model' => $model,
            'company' => $company,
            'users' => $users,
        ]);
    }
}
