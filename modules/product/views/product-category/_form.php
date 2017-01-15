<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?php
    $identify = (Object) Yii::$app->user->identity;
    ?>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="subordinate_company">所属公司</label>
        <div class="col-sm-9">
            <input class="form-control" id="subordinate_company" type="text" readonly="readonly" value="<?=
            \app\modules\user\models\Company::findOne($identify->company_id)->getAttribute('name');
            ?>">
        </div>
    </div>
    <?= $form->field($model, 'company_id')->hiddenInput(['value'=>$identify->company_id])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
        $condition = $model->isNewRecord ? ['status'=>0,'superior_id'=>0] : ['and','status=0','superior_id=0', ['not in', 'id',$model->id]];
    ?>
    <?= $form->field($model, 'superior_id')->dropDownList([0 => '无'] + \app\modules\product\models\ProductCategory::find()->select(
            ['name','id'])->where($condition)->indexBy('id')->column()) ?>

    <?= $form->field($model, 'avisible')->checkboxList([
        8 => '直属上级',
        4 => '直属下级',
        2 => '集团内旁枝',
        1 => '集团外公司',
    ]) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
