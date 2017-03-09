<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\Product */

$this->title = '基本信息';
$this->params['breadcrumbs'][] = ['label' => '产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$actionId = Yii::$app->requestedAction->id;
?>
<div class="product-update">
    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id=' . $model->id], ['class' => $actionId=='update' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
        <?= Html::a('产品价格', ['price?id=' . $model->id], ['class' => $actionId=='price' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
