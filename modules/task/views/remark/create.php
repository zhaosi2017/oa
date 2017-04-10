<?php

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskRemark */

$this->title = '新增备注';
$this->params['breadcrumbs'][] = ['label' => '任务备注', 'url' => ['/task/remark/index','id'=>Yii::$app->request->get('task_id')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-remark-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
