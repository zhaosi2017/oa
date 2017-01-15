<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'execute_type')->textInput() ?>

    <?= $form->field($model, 'fee_settlement')->textInput() ?>

    <?= $form->field($model, 'customer_category')->textInput() ?>

    <?= $form->field($model, 'customer_grate')->textInput() ?>

    <?= $form->field($model, 'company_cuntomer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'superior_task_id')->textInput() ?>

    <?= $form->field($model, 'create_author_uid')->textInput() ?>

    <?= $form->field($model, 'update_author_uid')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
