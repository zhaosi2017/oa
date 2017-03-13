<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\FinanceSubject */

$this->title = '编辑科目';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '财务科目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-subject-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
