<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\NoticeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['user-index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'status')->dropDownList([0=>'未读',1=>'已读'],['prompt'=>'全部状态','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>
        </div>
        <div class="col-lg-6">
            <div class="pull-right">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '通知内容',
                    2 => '发件人',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','onclick'=>'
                        $("#noticesearch-status").val("");
                    ']) ?>
                </div>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
