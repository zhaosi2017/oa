<?php

//use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\product\models\RootCategory */

$this->title = '根分类设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="root-category-set">

    <?= $this->render('root_form', [
        'model' => $model,
    ]) ?>

</div>

