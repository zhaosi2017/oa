<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use app\modules\product\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $TaskSearch = Yii::$app->request->get('TaskSearch');
    $second_category_column = [];
    if(is_array($TaskSearch)){
        if(!empty($TaskSearch['search_keywords'])){
            $model->search_type = $TaskSearch['search_type'];
            $model->search_keywords = $TaskSearch['search_keywords'];
        }else{
            $model->first_product_category = $TaskSearch['first_product_category'];
            $model->second_product_category = $TaskSearch['second_product_category'];
            $model->execute_type = $TaskSearch['execute_type'];
            $model->fee_settlement = $TaskSearch['fee_settlement'];
            $model->top_level_task = $TaskSearch['top_level_task'];
            $second_category_column = \app\modules\product\models\ProductCategory::find()->getChildren($model->first_product_category);
        }
    }
?>
<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['sent-index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'first_product_category')->dropDownList($model->getFirstProductCategory(),['prompt'=>'--产品一级分类--',
                'onchange' => '
                    var first_category_id = $(this).val();
                    var url= \''.\yii\helpers\Url::to(['/product/product-category/get-second-category']).'\';
                    $.post(url,{"first_category_id":first_category_id}).done(function(r){
                        $("#tasksearch-second_product_category").html(r);
                    });
            '])->label('筛选：') ?>

            <?= $form->field($model, 'second_product_category')->dropDownList($second_category_column,['prompt'=>'--产品二级分类--','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model, 'status')->dropDownList($model->getStatuses(),['prompt'=>'--全部状态--','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model, 'execute_type')->dropDownList([1=>'一次性',2=>'重复'],['prompt'=>'--执行方式--','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model, 'fee_settlement')->dropDownList([1=>'全包',2=>'独立'],['prompt'=>'--费用结算--','onchange'=>'
                $("#search_hide").click();
            '])->label(false) ?>

            <?= $form->field($model, 'top_level_task')->dropDownList([0=>'仅显示顶级父任务'],['prompt'=>'--任务筛选--','onchange'=>'
                $("#search_hide").click();
            ' ])->label(false) ?>

        </div>
        <div class="col-lg-6">
            <div class="pull-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '任务名称&编号',
                    2 => '任务要求',
                    3 => '上级任务&编号',
                    4 => '客户',
                    5 => '执行公司',
                    6 => '创建人',
                    7 => '最后修改人',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>

                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#tasksearch-first_product_category").val("");
                        $("#tasksearch-second_product_category").val("");
                        $("#tasksearch-status").val("");
                        $("#tasksearch-execute_type").val("");
                        $("#tasksearch-fee_settlement").val("");
                        $("#tasksearch-top_level_task").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
