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

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'superior_id')->dropDownList([0 => '无'] + $model->categoryList()) ?>

    <?php /*= $form->field($model, 'avisible',[
        'template' => "{label}\n<div class=\"col-sm-9\">{input}
            \n<span class=\"help-block m-b-none\">(直属上级勾选后，直属上级公司在发布任务选择产品的时候，可以使用该分类中的产品，若取消勾选，则直属上级单位看不到也选不到该分类下的任何产品；直属下级功能类似，但用来针对直属下级公司；集团内旁枝是指同一个集团公司中除直属上级和直属下级外的其它公司，是否可以看到本分类和分类下的产品；集团外公司是指不属于同一集团下的公司，是否可以看到本分类和分类下的产品。若均不勾选，则表示仅自己公司可见。)</span></div>"
    ])->checkboxList([
        8 => '直属上级',
        4 => '直属下级',
        2 => '集团内旁枝',
        1 => '集团外公司',
    ]) */?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
