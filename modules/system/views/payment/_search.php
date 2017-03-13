<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskPayInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'pay_company_name')->dropDownList(\app\modules\user\models\Company::find()->downList(),['prompt'=>'全部付款公司','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>
            <?= $form->field($model,'status')->dropDownList([0=>'待付款',2=>'已经付款'],['prompt'=>'全部状态','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>
        </div>
        <div class="col-lg-6">
            <div class="pull-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '付款单编号',
                    2 => '任务编号',
                    3 => '执行公司',
                    4 => '付款公司',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#taskcollectioninfosearch-status").val("");
                        $("#taskcollectioninfosearch-type").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
