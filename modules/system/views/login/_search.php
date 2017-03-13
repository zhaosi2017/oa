<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\StatementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['record'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'status')->dropDownList([0=>'登录成功',2=>'密码错误',3=>'验证错误'],['prompt'=>'全部状态','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>
        </div>
        <div class="col-lg-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '用户名称',
                    2 => '登录IP',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#loginlogssearch-status").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
