<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?php
        $product_category = \app\modules\product\models\ProductCategory::find();
        $categoryList = $product_category->select(['name','id','superior_id'])->where(['status' => 0])->all();
        $one_category = $model['firstCategory'];

        $child_category = [];
        $option_arr = [];

        foreach ($categoryList as $item){
            if($item->superior_id != 0){

                if($model->second_category_id == $item->id){
                    $model->first_category_id = $item->superior_id;
                }

                $child_category[$item->superior_id][$item->id] = $item->name;
                $option_arr[$item->superior_id][] = '<option value="'.$item->id.'">'.$item->name.'</option>';
            }
        }

        $second_category = !empty($child_category) && !empty($one_category)
            ? $child_category[$model->isNewRecord ? key($one_category) : $model->first_category_id]
            : [];

        //js json
        foreach ($option_arr as $k => $v){
            $option_arr[$k] = implode(',', $v);
        }

        $option_json = json_encode($option_arr, JSON_UNESCAPED_UNICODE);

    ?>

    <?= $form->field($model, 'first_category_id')->dropDownList(
        $one_category,
        [
            'onchange' => '
                var one_level = $(this).val();
                var option_json = '.$option_json.';
                $("#product-second_category_id").html(option_json[one_level]);
            ',
        ]
    )->label('产品分类') ?>

    <?= $form->field($model, 'second_category_id')->dropDownList($second_category)->label('') ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => 200,'placeholder' => '限200字']) ?>

    <?= $form->field($model, 'enable')->radioList([
            0 => '可用',
            1 => '停用',
    ]) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
