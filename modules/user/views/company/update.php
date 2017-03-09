<?php

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Company */

$this->title = '编辑公司';
$this->params['breadcrumbs'][] = ['label' => '用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '公司管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
