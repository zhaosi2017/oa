<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\customer\models\Customer */

$this->title = '编辑客户: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
