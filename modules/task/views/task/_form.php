<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-10\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'execute_type')->radioList([1=>'一次性',2=>'重复'],['value'=>1]) ?>

    <?= $form->field($model, 'fee_settlement')->radioList([1=>'全包',2=>'独立'],['value'=>1]) ?>

    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">客户</label>
            </div>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'customer_category')->dropDownList([1=>'外部客户',2=>'集团公司'],[
                'prompt'=>'--客户类别--',
                'onchange'=>'
                $.post("'.Url::to(['/task/task/customer']).'",{"customer_category": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#task-company_customer_id").html(data);
                });',
            ])->label(false) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'company_customer_id')->dropDownList([],[
                'prompt'=>'--请选择客户--',
                'onchange'=>'
                $.post("'.Url::to(['/task/task/grade']).'",{"customer_category": $("#task-customer_category").val(),"company_customer_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#task-customer_grate").val(data);
                });',
            ])->label(false) ?>
        </div>
        <div class="col-sm-1 form-inline">
            <?= $form->field($model, 'customer_grate')->dropDownList([''=>'--级别--',0=>'未评级', 1=>'A',2=>'B',3=>'C',4=>'D'],['disabled'=>'disabled'])->label(false) ?>
        </div>
    </div>


    <div class="form-group field-task-product-btn">
        <label class="col-sm-2 control-label" for="task-product-btn">产品</label>
        <div class="col-sm-10"><input type="button" id="task-product-btn" class="btn btn-block btn-outline btn-primary" value="选择">
            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>产品名称(编号)</span></div>
    </div>

    <?= $form->field($model, 'product_id')->hiddenInput()->label(' ') ?>

    <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'attachment',
        [
            'template' => "{label}\n<div class=\"col-sm-10\">{input}
            \n<span class=\"help-block m-b-none\"><i class=\"fa fa-info-circle\"></i>(由于安全原因，当前附件仅允许上传zip、rar、7z格式的压缩包，且仅限上传一个附件！)</span></div>"
        ])->fileInput(['class'=>'form-control']) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$url = Url::to(["/task/task/product-search"]);

$this->registerJs('
    
        $("#task-product-btn").click(function(){
            if($("#task-customer_grate").val()>0){
                var url = \''.$url.'?grade=\' + $("#task-customer_grate").val();
                parent.layer.open({
                    type: 2,
                    title: \'产品选择\',
                    shadeClose: true,
                    shade: 0.8,
                    area: [\'80%\', \'90%\'],
                    content: url
                });
            }else{
                layer.alert("请选择评过级的客户后再进行此操作",{skin: \'layui-layer-molv\'});
            }
        });
    
');
?>