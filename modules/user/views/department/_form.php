<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\user\models\Company;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?php

        //todo 只显示和部门相关公司关联的数据，其余的不显示

        //所有公司 type Object
        $optionsMapArr = $optionsHtmlArr = $comListMap = Company::find()->select(['name'])->where(['status'=>0])->indexBy('name')->column();

        //所有部门 type Object
        $supList = $model::find()->select(['id','name','company_name'])->where(['status'=>0])->all();

        $supListMap = ArrayHelper::map($supList,'id','name') + [0 => '无'];

        foreach ($optionsHtmlArr as $item){
            $optionsMapArr[$item] = [0=>'无'];
            $optionsHtmlArr[$item] = '<option value="0">无</option>';
        }

        foreach ($supList as $item){
            $optionsMapArr[$item->company_name][$item->id] = $item->name;
            $optionsHtmlArr[$item->company_name] .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        $optionJson = json_encode($optionsHtmlArr,JSON_UNESCAPED_UNICODE);

        if($model->company_name){
            $supListMap = $optionsMapArr[$model->company_name];
        }else{
            $supListMap = $optionsMapArr[current($comListMap)];
        }

    ?>

    <?= $form->field($model, 'company_name')->dropDownList($comListMap,
        ['onchange' => '
            var comName = $(this).val();
            var changeCom = '.$optionJson.';
            $("#department-superior_department_id").html(changeCom[comName]);      
        ']
    ) ?>

    <?= $form->field($model, 'superior_department_id')->dropDownList($supListMap) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
