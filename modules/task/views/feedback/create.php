<?php

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskFeedback */

$this->title = '新增执行反馈';
$this->params['breadcrumbs'][] = ['label' => '执行反馈', 'url' => ['/task/feedback/index','id'=>Yii::$app->request->get('id')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-feedback-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
