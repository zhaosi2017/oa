<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\product\models\Product */

$this->title = '新增产品';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
