<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '编辑岗位';
$this->params['breadcrumbs'][] = ['label'=>'用户','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '岗位管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="posts-update">

    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='auth' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('权限设置', ['auth?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
