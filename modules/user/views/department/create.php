<?php

//use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Department */

//$this->title = Yii::t('app', 'Create Department');//todo 多语言支持
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->title = '新增部门';
$this->params['breadcrumbs'][] = ['label'=>'用户','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '部门管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
