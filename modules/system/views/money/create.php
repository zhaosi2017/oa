<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\system\models\Money */

$this->title = '新增货币';
$this->params['breadcrumbs'][] = ['label' => 'Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
