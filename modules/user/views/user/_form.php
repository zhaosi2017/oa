<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\models\Department;
use app\modules\user\models\Posts;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>


    <?php
        //所有岗位
        $postsList = Posts::find()->select(['id','department_id','company_name','name'])->where(['status'=>0])->indexBy('id')->all();

        //与岗位相关的所有公司、部门、岗位
        $allCompany = [];
        $allDepartment = [];
        $allPosts = [];

        //js json数组
        $departmentJsonArr = [];
        $postsJsonArr = [];
        //所有部门
        $departmentMap = Department::find()->select(['name','id'])->where(['status'=>0])->indexBy('id')->column();


        foreach ($postsList as $v){
            $departmentJsonArr[$v->company_name] = '';
            $postsJsonArr[$v->department_id] = '';
        }

        foreach ($postsList as $item){
            $allCompany[$item->company_name] = $item->company_name;

            $allPosts[$item->department_id][$item->id] = $item->name;

            //js json数组
            //去重
            if(!isset($allDepartment[$item->company_name][$item->department_id])){
                $allDepartment[$item->company_name][$item->department_id] = $departmentMap[$item->department_id];
                $departmentJsonArr[$item->company_name] .= '<option value="'.$item->department_id.'">'.$departmentMap[$item->department_id].'</option>';
            }

            $postsJsonArr[$item->department_id] .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }

//        var_dump($departmentJsonArr);exit;


        //所有公司
        $comListMap = $allCompany;


        //默认下拉列表
        if($model->company_name){
            $departmentMap = $allDepartment[$model->company_name];
            $postsMap = $allPosts[$model->department_id];
        }else{
            //当前公司下的所有部门
            $departmentMap = $allDepartment[current($comListMap)];
            //当前部门下的所有岗位
            $postsMap = $allPosts[key($departmentMap)];
        }

        //change 事件
        $departmentJson = json_encode($departmentJsonArr,JSON_UNESCAPED_UNICODE);
        $postsJson = json_encode($postsJsonArr,JSON_UNESCAPED_UNICODE);

    ?>

    <?= $form->field($model, 'company_name')->dropDownList($comListMap,
        ['onchange' => '
            var comName = $(this).val();
            var departmentOptions = '.$departmentJson.';
            var postsOptions = '.$postsJson.';
            $("#user-department_id").html(departmentOptions[comName]);
            
            var devId =  $("#user-department_id").val();
            $("#user-posts_id").html(postsOptions[devId]);   
        ']
    ) ?>


    <?= $form->field($model, 'department_id')->dropDownList($departmentMap,
        ['onchange' => '
            var devId = $(this).val();
            var postsOptions = '.$postsJson.';
            $("#user-posts_id").html(postsOptions[devId]);   
        ']
    )?>

    <?= $form->field($model, 'posts_id')->dropDownList($postsMap) ?>


    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
