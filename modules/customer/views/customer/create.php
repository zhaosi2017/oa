<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\customer\models\Customer */

$this->title = '新增客户';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <p>所属公司:<?= Yii::$app->user->identity->company_name ?></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
