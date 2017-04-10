<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'first_category_id')->dropDownList(
        $model['firstCategory'],
        [
            'prompt' => '--产品一级分类--',
            'onchange' => '
                $.post("'.\yii\helpers\Url::to(['/product/product-category/get-second-category']).'",{"first_category_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#product-second_category_id").html(data);
                });
            ',
        ]
    )->label('产品分类') ?>

    <?= $form->field($model, 'second_category_id')->dropDownList($model->isNewRecord ? [] : $model->getSecondCategory(),['prompt'=>'--产品二级分类--'])->label('') ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => 10]) ?>

    <?php echo $form->field($model, 'description')->widget(Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'imageUpload' => false,
            'fileUpload' => false,
            'plugins' => [
                'clips',
                'fontcolor'
            ],
            'placeholder'=>'限200个字',
            'maxlength'=>200
        ]
    ]) ?>

    <?= $form->field($model, 'enable')->radioList([0 => '可用', 1 => '停用']) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
