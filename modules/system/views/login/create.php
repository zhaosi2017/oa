<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\LoginLogs */

$this->title = 'Create Login Logs';
$this->params['breadcrumbs'][] = ['label' => 'Login Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-logs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
