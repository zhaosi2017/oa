<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskPayInfo */

$this->title = 'Create Task Pay Info';
$this->params['breadcrumbs'][] = ['label' => 'Task Pay Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pay-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
