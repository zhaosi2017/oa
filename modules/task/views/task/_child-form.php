<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $parent_model */
/* @var $rate_model */
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('子任务名称') ?>

    <div class="form-group" id="product-company">
        <label class="col-sm-2 control-label" for="product-company">项目编号</label>
        <div class="col-sm-10">
            <input title="" type="text" readonly="readonly" class="form-control" value="<?= Yii::$app->request->get('number') ?>">
        </div>
    </div>

    <?= $form->field($model, 'execute_type')->radioList([1=>'一次性',2=>'重复'],['value'=>1]) ?>

    <?= $form->field($model, 'fee_settlement')->radioList([1=>'全包',2=>'独立'],['value'=>1]) ?>

    <div class="row form-inline">
        <div class="col-lg-2 text-right">
            <div class="form-group">
                <label for="task-customer-category" class="col-sm-12 control-label">客户名称</label>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="form-group">
                <div class="col-sm-10">
                    <input title="" class="form-control" readonly="readonly" type="text" value="<?= $parent_model['company']['name'] ?>">
                    <span class="help-block m-b-none"></span>
                </div>
            </div>
            <span>(级别：<a id="display-grade"><?= $grade[$rate_model->grade] ?></a>)</span>
            <?= $form->field($model,'company_customer_id')->hiddenInput(['value'=>$parent_model['company_id']])->label(false) ?>

            <?= $form->field($model, 'company_id')->hiddenInput(['value' => $identity->company_id])->label(false) ?>

            <?= $form->field($model, 'superior_task_id')->hiddenInput(['value' => Yii::$app->request->get('task_id')])->label(false) ?>

            <?= $form->field($model, 'customer_category')->hiddenInput(['value' => 2])->label(false) ?>

            <?= $form->field($model, 'customer_grate')->hiddenInput(['value'=>$rate_model->grade])->label(false) ?>
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
        <label class="col-sm-2 control-label" for="product-requirement">产品说明</label>
        <div class="col-sm-10">
            <textarea title="" class="form-control" rows="6"></textarea>
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

    <?= $form->field($model, 'product_id')->hiddenInput()->label(' ') ?>

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
        <div class="col-sm-6 col-sm-offset-2">
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