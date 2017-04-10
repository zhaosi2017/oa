<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = '登录权限';
$this->params['breadcrumbs'][] = ['label' => '用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="user-update">
    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='permission' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('登录权限', ['permission?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>
    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'options'=>['class'=>'form-horizontal m-t'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]) ?>

        <?php
            $email_suffix = '';
            if($model->email){
                $email_handle = explode('@', $model->email);
                $model->email = $email_handle[0];
                $email_suffix = $email_handle[1];
            }else{
                $model->email = '';
            }
        ?>

        <div class="row form-inline">
            <div class="col-lg-3 text-right">
                <div class="form-group">
                    <label for="task-customer-category" class="col-sm-12 control-label">验证邮箱</label>
                </div>
            </div>
            <div class="col-lg-9">
                <?= $form->field($model, 'email')->textInput(['maxlength' => 30])->label(false) ?>

                <div class="form-group">
                    <div class="col-sm-9">
                        <select title="" name='email-postfix' class='form-control'>
                            <option <?= $email_suffix=='gmail.com' ? 'selected="selected"' : '' ?> value='@gmail.com'>@gmail.com</option>
                            <option <?= $email_suffix=='697.com' ? 'selected="selected"' : '' ?> value='@697.com'>@697.com</option>
                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>

            </div>
        </div>

        <?= $form->field($model, 'login_permission')->radioList([
            '1' => '禁止',
            '0' => '允许'
        ]) ?>

        <?= $form->field($model, 'status')->checkboxList([
            '2' => '手动解锁',
        ],['name' => 'unlock']) ?>

        <?= $form->field($model, 'password')->checkboxList([
            $model->password => '重置密码(新密码为：'.$model->password.')'
        ]) ?>


        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
