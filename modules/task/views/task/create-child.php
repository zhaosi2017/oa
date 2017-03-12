<?php

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $parent_model */
/* @var $rate_model */

$this->title = '创建子任务';
$this->params['breadcrumbs'][] = ['label' => '任务', 'url' => ''];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?= $this->render('_child-form', [
        'model' => $model,
        'parent_model' => $parent_model,
        'rate_model' => $rate_model,
    ]) ?>

</div>
