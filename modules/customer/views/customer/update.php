<?php

/* @var $this yii\web\View */
/* @var $model app\modules\customer\models\Customer */

$this->title = '编辑客户';
$this->params['breadcrumbs'][] = ['label' => '客户', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '外部客户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
