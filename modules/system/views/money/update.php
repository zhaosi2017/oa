<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\Money */

$this->title = '编辑货币: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="money-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
