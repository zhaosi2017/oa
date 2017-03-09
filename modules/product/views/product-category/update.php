<?php

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductCategory */

$this->title = '编辑产品分类';
$this->params['breadcrumbs'][] = ['label' => '产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '产品分类', 'url' => ['index', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
