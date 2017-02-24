<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model,'first_category_id')->dropDownList($model->getFirstCategory(),['prompt'=>'产品一级分类','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>

            <?= $form->field($model,'second_category_id')->dropDownList($model->getSecondCategory(),['prompt'=>'产品二级分类','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model,'enable')->dropDownList(['1'=>'停用','0'=>'可用'],['prompt'=>'可用状态','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

        </div>
        <div class="col-lg-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '产品名称',
                    2 => '创建人',
                    3 => '最后修改人',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#productsearch-first_category_id").val("");
                        $("#productsearch-second_category_id").val("");
                        $("#productsearch-status").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
