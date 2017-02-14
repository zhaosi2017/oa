<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskFeedbackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-feedback-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-sm-12">
            <div class="btn-group">
                <?= Html::a('列表', ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('垃圾筒', ['trash'], ['class' =>  'btn btn-outline btn-default']) ?>
            </div>
            <div class="form-group pull-right">
                <?= Html::a('新增执行反馈', ['create'], ['class'=>'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
