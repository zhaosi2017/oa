<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\StatementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'first_subject_id')->dropDownList($model->getFirstSubject(),['prompt'=>'一级科目','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>

            <?= $form->field($model,'second_subject_id')->dropDownList($model->getSecondSubject(),['prompt'=>'二级科目','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model,'type')->dropDownList([1=>'公司',2=>'任务'],['prompt'=>'流水类型','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model,'direction')->dropDownList([1=>'支出',2=>'收入'],['prompt'=>'记账方向','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <br>
            <?= $form->field($model,'accounting_start_date')->input('date',['prompt'=>'请选择'])->label('记账日期：') ?>
            至
            <?= $form->field($model,'accounting_end_date')->input('date',['prompt'=>'请选择'])->label(false) ?>
            <div class="btn-group">
                <a class="btn btn-xs btn-primary" onclick="
                    $('#search_hide').click();
                ">筛选</a>
                <a class="btn btn-xs btn-danger" onclick="
                    $('#statementsearch-accounting_start_date').val('');
                    $('#statementsearch-accounting_end_date').val('');
                ">清除</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '科目名称',
                    2 => '任务名称&编号',
                    3 => '创建人',
                    4 => '最后修改人',
                    5 => '备注说明',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#statementsearch-first_subject_id").val("");
                        $("#statementsearch-first_subject_id").val("");
                        $("#statementsearch-type").val("");
                        $("#statementsearch-direction").val("");
                        $("#statementsearch-accounting_start_date").val("");
                        $("#statementsearch-accounting_end_date").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
