<?php

namespace app\modules\user\controllers;

use Yii;
use app\controllers\GController;
use app\modules\user\models\Company;

/**
 * Default controller for the `user` module
 */
class CompanyController extends GController
{

    public function actionAdd()
    {
        $model = new Company();
        $companyList = $model->getCompanyList();

        if(Yii::$app->request->isAjax){
            $model->addHandle();
        }
        return $this->render('add',['companyList'=>$companyList]);

    }

    public function actionEdit()
    {
        $model = new Company();

        $gets = Yii::$app->request->get();
        $oneCompany = $model->oneCompany(['name'=>$gets['name']]);

        $companyList = $model->filterCompanyList($oneCompany['level']-1);

        if(Yii::$app->request->isAjax){
            $model->editHandle();
        }
        return $this->render('edit',['companyList'=>$companyList,'oneCompany'=>$oneCompany]);

    }

    public function actionIndex()
    {
        $model = new Company();
        if(Yii::$app->request->isAjax){
            $model->listHandle();
        }
        return $this->render('index');
    }

    public function actionTrash()
    {
        $model = new Company();
        if(Yii::$app->request->isAjax){
            $model->listHandle();
        }
        return $this->render('trash');
    }

    public function actionDisable()
    {
        $model = new Company();
        if(Yii::$app->request->isAjax){
            $posts = Yii::$app->request->post();
            if($model->oneCompany(["superior_company_name"=>$posts["name"],"status"=>0])){
                $this->ajaxResponse([
                    'code' => 1,
                    'msg'  => '当前公司下具有状态为正常的公司，不能作废！',//todo
                    'data' => []
                ]);
            }
            if($model->changeStatus($posts["status"],["name" => $posts["name"]])){
                $this->ajaxResponse([
                    'code' => 0,
                    'msg'  => '操作成功',
                    'data' => $model->oneCompany(["name"=>$posts["name"]])
                ]);
            }else{
                $this->ajaxResponse([
                    'code' => 1,
                    'msg'  => '操作失败',
                    'data' => []
                ]);
            }
        }
        return;
    }
}
