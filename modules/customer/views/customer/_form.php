<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$identity = (Object) Yii::$app->user->identity;
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value' => $identity->company_id])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->dropDownList([1=>'A',2=>'B',3=>'C',4=>'D']) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
