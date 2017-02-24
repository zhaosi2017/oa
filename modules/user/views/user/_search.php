<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'company_id')->dropDownList($model->getCompanyList(),['prompt'=>'全部公司','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>

            <?= $form->field($model,'department_id')->dropDownList($model->getDepartmentList(),['prompt'=>'全部部门','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model,'posts_id')->dropDownList($model->getPostsList(),['prompt'=>'全部岗位','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model,'login_permission')->dropDownList([0=>'允许',1=>'禁止'],['prompt'=>'登录许可','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

        </div>
        <div class="col-lg-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '姓名',
                    2 => '创建人',
                    3 => '最后修改人',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#usersearch-company_id").val("");
                        $("#usersearch-department_id").val("");
                        $("#usersearch-posts_id").val("");
                        $("#usersearch-login_permission").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
