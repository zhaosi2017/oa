<?php

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductCategory */

$this->title = '新增产品分类';
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
