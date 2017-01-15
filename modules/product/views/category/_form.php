<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\RootCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="root-category-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visible')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_author_uid')->textInput() ?>

    <?= $form->field($model, 'update_author_uid')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
