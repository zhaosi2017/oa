<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'company_id')->dropDownList(\app\modules\user\models\Company::find()->downList(),['prompt'=>'全部公司','onchange'=>'
                $("#search_hide").click();
            '])->label('筛选：') ?>
            <br>
            <?= $form->field($model, 'visible')->checkboxList([
                8 => '直属上级',
                4 => '直属下级',
                2 => '集团内旁枝',
                1 => '集团外公司',
            ],['onclick'=>'
                $("#search_hide").click();
            '])->label('可见：') ?>
        </div>
        <div class="col-lg-6">
            <div class="text-right no-padding">
                <?= $form->field($model, 'search_type')->dropDownList([
                    1 => '分类名称',
                ])->label(false) ?>
                <?= $form->field($model, 'search_keywords')->textInput()->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary m-t-n-xs','id'=>'search','onclick'=>'
                        $("#usersearch-company_id").val("");
                    ']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
