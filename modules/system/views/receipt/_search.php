<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskCollectionInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-collection-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'status')->dropDownList([0=>'待收款',2=>'已收款'],['prompt'=>'全部状态','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>
            <?= $form->field($model,'type')->dropDownList([0=>'现金收取',2=>'集团托收'],['prompt'=>'收款方式','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>
        </div>
        <div class="col-lg-6">
            <div class="pull-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '收款单编号',
                    2 => '任务编号',
                    3 => '客户名称',
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
