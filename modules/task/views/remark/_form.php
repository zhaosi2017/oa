<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskRemark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-remark-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->hiddenInput(['value'=>Yii::$app->request->get('task_id')])->label(false) ?>

    <?= $form->field($model, 'content')->widget(Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'imageUpload' => false,
            'fileUpload' => false,
            'plugins' => [
                'clips',
                'fontcolor'
            ],
            'placeholder'=>'限500个字',
            'maxlength'=>500,
            'required'=>'required',
        ]
    ])->label(false) ?>

    <div class="text-right">
        <?= Html::submitButton('提交', ['class' => 'btn btn-sm btn-primary','id'=>'submit-btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
