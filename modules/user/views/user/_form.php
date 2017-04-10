<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\user\models\Department;
use app\modules\user\models\Posts;
use app\modules\user\models\Company;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => 10]) ?>

    <?php

        $companyMap = Company::find()->downList();
        $departmentMap = [];
        $postsMap = [];

        if(!$model->isNewRecord){
            $departmentMap = Department::find()->downList($model->company_id);
            $postsMap = Posts::find()->downList($model->department_id);
        }


    ?>

    <?= $form->field($model, 'company_id')->dropDownList($companyMap,
        [
            'prompt'=>'--请选择--',
            'onchange'=>'
            $.post("'.Url::to(['/user/user/department']).'",{"company_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                $("#user-department_id").html(data);
            });',
        ]
    ) ?>


    <?= $form->field($model, 'department_id')->dropDownList($departmentMap,
        [
            'prompt'=>'--请选择--',
            'onchange'=>'
            $.post("'.Url::to(['/user/user/posts']).'",{"department_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                $("#user-posts_id").html(data);
            });',
        ]
    )?>

    <?= $form->field($model, 'posts_id')->dropDownList($postsMap,['prompt'=>'--请选择--']) ?>


    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
