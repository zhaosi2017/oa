<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */

$identity = (Object) Yii::$app->user->identity;

$grade = [''=>'未设置',0=>'未评级', 1=>'A',2=>'B',3=>'C',4=>'D'];
?>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal m-t', 'enctype'=>'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-10\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value' => $identity->company_id])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'execute_type')->radioList([1=>'一次性',2=>'重复'],['value'=>1]) ?>

    <?= $form->field($model, 'fee_settlement')->radioList([1=>'全包',2=>'独立'],['value'=>1]) ?>

    <div class="row form-inline">
        <div class="col-lg-2 text-right">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">客户</label>
            </div>
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'customer_category')->dropDownList([1=>'外部客户',2=>'集团公司'],[
                'prompt'=>'--客户类别--',
                'onchange'=>'
                $.post("'.Url::to(['/task/task/customer']).'",{"customer_category": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#task-company_customer_id").html(data);
                });',
            ])->label(false) ?>

            <?php /*echo $form->field($model, 'company_customer_id')->dropDownList([],[
                'prompt'=>'--请选择客户--',
                'onchange'=>'
                $.post("'.Url::to(['/task/task/grade']).'",{"customer_category": $("#task-customer_category").val(),"company_customer_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},function(data){
                    $("#task-customer_grate").val(data);
                    var grade = ["未评级","A","B","C","D"];
                    $("#display-grade").html(grade[data]);
                });',
            ])->label(false) */?>

            <?php
                echo $form->field($model, 'company_customer_id')->widget(Select2::className(),[
                'data' => [],
                'options' => ['placeholder' => '--请选择客户--','onchange'=>'
                    $.post("'.Url::to(['/task/task/grade']).'",
                        {"customer_category": $("#task-customer_category").val(),"company_customer_id": $(this).val(),"_csrf":"'.Yii::$app->request->csrfToken.'"},
                        function(data){
                            $("#task-customer_grate").val(data);
                            var grade = ["未评级","A","B","C","D"];
                            $("#display-grade").html(grade[data]);
                    });
                '],
            ])->label(false) ?>

            <span>(级别：<a id="display-grade">-</a>)</span>
            <?= $form->field($model, 'customer_grate')->dropDownList($grade,[
                'class'=>'hide',
                'readonly'=>'readonly',
                'onfocus'=>'this.defaultIndex=this.selectedIndex;',
                'onchange'=>'this.selectedIndex=this.defaultIndex;'
            ])->label(false) ?>
        </div>
    </div>


    <div class="form-group field-task-product-btn">
        <label class="col-sm-2 control-label" for="task-product-btn">产品</label>
        <div class="col-sm-10"><input type="button" id="task-product-btn" class="btn btn-block btn-outline btn-primary" value="选择">
            <span class="help-block m-b-none" id="product-name-number">产品名称(编号)</span>
        </div>
    </div>

    <div class="form-group hide" id="product-company">
        <label class="col-sm-2 control-label" for="product-company">产品所属公司</label>
        <div class="col-sm-10">
            <input title="" type="text" class="form-control" value="公司名称">
        </div>
    </div>
    <div class="form-group hide" id="product-requirement">
        <label class="col-sm-2 control-label" for="product_requirement">产品说明</label>
        <div class="col-sm-10">
            <div id="product_requirement" style="padding: 6px 12px"></div>
        </div>
    </div>
    <div class="form-group hide" id="product_price_table">
        <b class="col-sm-2 control-label">产品价格</b>
        <div class="col-sm-10">
            <table class="table table-bordered text-center">
                <!--<tr>
                    <th>货币</th>
                    <th>购买价格</th>
                    <th>成交价格 </th>
                </tr>
                <tr>
                    <td>欢乐豆</td>
                    <td>100.00</td>
                    <td><input title="" class="form-control" id="bbbb" type="text" value="100.00"></td>
                </tr>
                <tr>
                    <td>美金</td>
                    <td>100.00 </td>
                    <td><input title="" class="form-control" id="aaaa" type="text" value="100.00"></td>
                </tr>-->
            </table>
        </div>
    </div>

    <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'requirement')->widget(Redactor::className(),[
        'clientOptions' => [
            'lang' => 'zh_cn',
            'imageUpload' => false,
            'fileUpload' => false,
            'plugins' => [
                'clips',
                'fontcolor'
            ],
            'placeholder'=>'限500个字',
            'maxlength'=>500
        ]
    ]) ?>

    <?= $form->field($model, 'file',
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
                layer.open({
                    type: 2,
                    title: \'产品选择\',
                    shade: 0.5,
                    area: [\'80%\', \'90%\'],
                    fixed: false,
                    shadeClose: true,
                    content: url,
                });
            }else{
                layer.alert("请选择评过级的客户后再进行此操作",{skin: \'layui-layer-molv\'});
            }
        });
    
');
?>