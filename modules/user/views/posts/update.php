<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '编辑岗位: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$actionId = Yii::$app->requestedAction->id;
?>
<div class="posts-update">

    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('权限设置', ['auth?id='.$model->id], ['class' => $actionId=='auth' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
