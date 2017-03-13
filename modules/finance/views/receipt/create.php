<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskCollectionInfo */

$this->title = 'Create Task Collection Info';
$this->params['breadcrumbs'][] = ['label' => 'Task Collection Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-collection-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
