<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\Statement */

$this->title = '编辑流水';
$this->params['breadcrumbs'][] = ['label' => 'Statements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="statement-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
