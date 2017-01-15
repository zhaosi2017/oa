<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\product\models\RootCategory */

$this->title = 'Create Root Category';
$this->params['breadcrumbs'][] = ['label' => 'Root Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="root-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
