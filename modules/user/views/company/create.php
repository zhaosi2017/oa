<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Company */

$this->title = '新增公司';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
