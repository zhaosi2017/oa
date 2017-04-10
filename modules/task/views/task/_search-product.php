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
        'action' => ['product-search','grade'=>$model->grade],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'root_category_id')->dropDownList($model->filterRootCategory(),['prompt'=>'--全部根分类--'])->label('筛选：') ?>
            <?= $form->field($model, 'first_category_id')->dropDownList($model->filterCategory(),[
                'prompt'=>'--产品一级分类--',
                'onchange'=>'
                    $.post("'.Url::to(['/task/task/second-category']).'",{"first_category_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                        $("#productsearch-second_category_id").html(data);
                    });',
            ])->label(false) ?>
            <?= $form->field($model, 'second_category_id')->dropDownList($model->filterCategory(),['prompt'=>'--产品二级分类--'])->label(false) ?>

        </div>
        <div class="col-sm-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '产品名称&编号'
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#productsearch-root_category_id").val("");
                        $("#productsearch-first_category_id").val("");
                        $("#productsearch-second_category_id").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
