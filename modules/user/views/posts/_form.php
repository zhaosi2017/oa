<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\user\models\Company;
use app\modules\user\models\Department;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php

        $companyMap = Company::find()->downList();
        $departmentMap = [];

        if(!$model->isNewRecord){
            $companyMap = [$model->company_id => $model['company']['name']];
            $departmentMap = Department::find()->downList($model->company_id);
        }

    ?>

    <?= $form->field($model, 'company_id')->dropDownList($companyMap,
        [
            'prompt'=>'--请选择--',
            'onchange'=>'
            $.post("'.Url::to(['/user/posts/department']).'",{"company_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                $("#posts-department_id").html(data);
            });',
        ]
    ) ?>


    <?= $form->field($model, 'department_id')->dropDownList($departmentMap, ['prompt'=>'--请选择--'])?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
