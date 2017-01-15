<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\Money */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'enable',
            'status',
            'create_author_uid',
            'update_author_uid',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
