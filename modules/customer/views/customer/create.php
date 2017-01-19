<?php

/* @var $this yii\web\View */
/* @var $model app\modules\customer\models\Customer */

$this->title = '新增客户';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
