<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = '用户详情';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$actionId = Yii::$app->requestedAction->id;
?>
<div class="user-update">
    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('登录权限', ['permission?id='.$model->id], ['class' => $actionId=='permission' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>
    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'options'=>['class'=>'form-horizontal m-t'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]) ?>

        <?php $email = $model->email ? explode('@',$model->email)[0] : '' ?>
        <?= $form->field($model, 'email',[
            'template' => "{label}\n<div class=\"col-sm-3\">{input}</div>
            <div class=\"col-sm-2\">
                <select name='email-postfix' class='form-control'>
                    <option value='@gmail.com'>@gmail.com</option>
                    <option value='@697.com'>@697.com</option>
                </select>
                <span class=\"help-block m-b-none\">{error}</span>
            </div>",
        ])->textInput(['maxlength' => true,'value' =>$email]) ?>


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
