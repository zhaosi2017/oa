<?php

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\Statement */

$this->title = '新增流水';
$this->params['breadcrumbs'][] = ['label'=>'财务','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '流水账', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statement-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
