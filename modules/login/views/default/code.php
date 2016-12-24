<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = '登录';

$useremail = isset($email) ? $email : '';

function handleEmail($str){
    $strArr = explode('@', $str);
    $str = explode('@', $str)[0];

    $res = substr_replace($str,"**",0,2);

    $res = substr_replace($res,"**",-1,2);
    return $res.'@'.$strArr[1];
}

?>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">OA</h1>

        </div>
        <h3>第一平台</h3>

        <blockquote>
            已向邮箱<?= $useremail ? handleEmail($useremail) : '' ?>发送登录验证码，请登录邮箱获取验证码！
        </blockquote>
        <?php $form = ActiveForm::begin([
            'id' => 'verify-form',
            'action' => 'code',
            'options'=>['class'=>'m-t text-left'],
        ]); ?>

        <?= $form->field($model, 'username')->hiddenInput(['value' => isset($model->username) ? $model->username : 'username'])->label(false) ?>

        <?= $form->field($model, 'password')->hiddenInput(['value' => isset($model->password) ? $model->password : 'password'])->label(false) ?>

        <?= $form->field($model, 'code')
            ->widget(Captcha::className(),[
            'captchaAction'=>'/login/default/captcha',
//            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
        ])
            ->textInput(['autofocus' => true,'placeholder'=>'请输入验证码'])
            ->label(false)
        ?>

        <?= Html::submitButton('确定', ['class' => 'btn btn-primary block full-width m-b']) ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
//var_dump($vcode);

?>


