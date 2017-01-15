<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'execute_type') ?>

    <?= $form->field($model, 'fee_settlement') ?>

    <?= $form->field($model, 'customer_category') ?>

    <?php // echo $form->field($model, 'customer_grate') ?>

    <?php // echo $form->field($model, 'company_cuntomer_name') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'requirement') ?>

    <?php // echo $form->field($model, 'attachment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'superior_task_id') ?>

    <?php // echo $form->field($model, 'create_author_uid') ?>

    <?php // echo $form->field($model, 'update_author_uid') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
