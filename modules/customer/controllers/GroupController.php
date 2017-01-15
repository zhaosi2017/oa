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
        $this->layout = '@app/views/layouts/form';
        $identity = (Object) Yii::$app->user->identity;
        if(Yii::$app->request->post()){
            $posts = Yii::$app->request->post();
            $model = new GroupRate();

            GroupRate::deleteAll(['rate_company_name'=>$identity->company_name]);
            $flag = true;
            foreach ($posts as $item){
                if(is_array($item) && isset($item['grade'])){
                    $add_model = clone $model;
                    $add_model->company_name = $item['name'];
                    $add_model->grade = $item['grade'];
                    $add_model->rater_uid = Yii::$app->user->id;
                    $flag = $add_model->save() && $flag;
                }
            }

            $flag && Yii::$app->getSession()->setFlash('success', '操作成功');

        }

        $company = Company::find()->select(['name','update_author_uid','update_time'])->where(['status'=>0])->all();
        $users = User::find()->select(['account','id'])->indexBy('id')->column() + [ 0=>'管理员'];
        $groupRate = GroupRate::find()->select(['grade','company_name'])->where(['rate_company_name'=>$identity->company_name])->indexBy('company_name')->column();
        return $this->render('rate',[
            'groupRate' => $groupRate,
            'company' => $company,
            'users' => $users,
        ]);
    }

    public function actionUpdate()
    {
        $company = Company::find()->select(['name','update_author_uid','update_time'])->where(['status'=>0])->all();
        $users = User::find()->select(['account','id'])->indexBy('id')->column() + [ 0=>'管理员'];
        $identity = (Object) Yii::$app->user->identity;
        $model = GroupRate::find()->select(['grade','company_name'])->where(['rate_company_name'=>$identity->company_name])->indexBy('company_name')->column();
        return $this->render('update',[
            'model' => $model,
            'company' => $company,
            'users' => $users,
        ]);
    }
}
