<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\Statement */

$this->title = '编辑流水';
$this->params['breadcrumbs'][] = ['label'=>'财务','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '流水账', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑流水';
?>
<div class="statement-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
