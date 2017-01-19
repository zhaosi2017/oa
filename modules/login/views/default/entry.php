<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\login\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '登录';
?>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">OA</h1>

        </div>
        <h3>第一平台</h3>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options'=>['class'=>'m-t text-left'],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'用户名'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'密码'])->label(false) ?>


        <?= Html::submitButton('登 录', ['class' => 'btn btn-primary block full-width m-b']) ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>


