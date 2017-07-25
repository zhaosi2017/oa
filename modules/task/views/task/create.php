<?php

//use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */

$this->title = '创建任务';
$this->params['breadcrumbs'][] = ['label' => '业务', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
