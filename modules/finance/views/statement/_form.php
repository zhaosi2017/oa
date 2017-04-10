<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\finance\models\Statement */
/* @var $form yii\widgets\ActiveForm */

$identity = (Object) Yii::$app->user->identity;
$company_name = \app\modules\user\models\Company::findOne($identity->company_id)->getAttribute('name');
?>

<div class="statement-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-7\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value' => $identity->company_id])->label(false) ?>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="sup_level">所属公司</label>
        <div class="col-sm-7">
            <input class="form-control" id="sup_level" type="text" readonly="readonly" value="<?= $company_name ?>">
        </div>
    </div>

    <div class="row form-inline">
        <div class="col-lg-3 text-right">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">流水科目</label>
            </div>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'first_subject_id')->dropDownList($model->getFirstSubject(),['prompt'=>'一级科目','onchange'=>'
                $.post("'.Url::to(['/finance/statement/get-second-subject']).'",{"first_subject_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                $("#statement-second_subject_id").html(data);
            });'])->label(false) ?>
            <?= $form->field($model, 'second_subject_id')->dropDownList($model->getSecondSubject(),['prompt'=>'二级科目'])->label(false) ?>
        </div>
    </div>

    <div class="row form-inline">
        <div class="col-lg-3 text-right">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">流水类型</label>
            </div>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'type')->dropDownList([1=>'公司',2=>'任务'],['prompt'=>'请选择','onchange'=>'
                $.post("'.Url::to(['/finance/statement/get-company-task']).'",{"type": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#statement-associate_id").html(data);
                });
            '])->label(false) ?>
            <?= $form->field($model, 'associate_id')->dropDownList($model->getAssociateCompanyTask(),['prompt'=>'请选择关联公司/任务'])->label(false) ?>
        </div>
    </div>

    <?= $form->field($model,'direction')->dropDownList([1=>'支出',2=>'收入'],['prompt'=>'记账方向']) ?>

    <div class="row form-inline">
        <div class="col-lg-3 text-right">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">记账金额</label>
            </div>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'money_id')->dropDownList($model['money'],['prompt'=>'请选择货币'])->label(false) ?>
            <?= $form->field($model, 'amount')->input('number',['step'=>'0.01'])->label(false) ?>
        </div>
    </div>

    <?= $form->field($model,'accounting_date')->input('date',['value'=> $model->isNewRecord ? date('Y-m-d',$_SERVER['REQUEST_TIME']) : $model->accounting_date]) ?>

    <?php echo $form->field($model, 'remark')->widget(\yii\redactor\widgets\Redactor::className(),[
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

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>