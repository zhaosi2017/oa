<?php

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\Money */

$this->title = '编辑货币' ;
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '货币管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
