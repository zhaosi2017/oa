<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['product-search'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2 form-inline">
            <?= $form->field($model, 'root_category_id')->dropDownList($model->filterRootCategory(),['prompt'=>'--全部根分类--'])->label(false) ?>
        </div>
        <div class="col-sm-2 form-inline">
            <?= $form->field($model, 'first_category_id')->dropDownList($model->filterCategory(),[
                    'prompt'=>'--产品一级分类--',
                    'onchange'=>'
                    $.post("'.Url::to(['/task/task/second-category']).'",{"first_category_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                        $("#productsearch-second_category_id").html(data);
                    });',
            ])->label(false) ?>
        </div>
        <div class="col-sm-2 form-inline">
            <?= $form->field($model, 'second_category_id')->dropDownList($model->filterCategory(),['prompt'=>'--产品二级分类--'])->label(false) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'name')->textInput(['placeholder'=>'产品名称','maxlength'=>20])->label(false) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'number')->textInput(['placeholder'=>'产品编号','maxlength'=>20])->label(false) ?>
        </div>

        <div class="col-sm-2">
            <div class="form-group pull-right">
                <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>
