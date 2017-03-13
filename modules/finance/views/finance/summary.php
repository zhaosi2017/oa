<?php
/* @var $this yii\web\View */
/* @var $searchModel \app\modules\system\models\MoneySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$identity = (Object) Yii::$app->user->identity;
$this->title = '公司账目汇总';
$this->params['breadcrumbs'][] = ['label'=>'财务','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="summary-index">

    <div class="help-block m-t"></div>

    <div class="summary-search">

        <?php $form = ActiveForm::begin([
            'action' => ['/finance/finance/summary'],
            'method' => 'get',
            'options' => ['class'=>'form-inline'],
        ]); ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="control-label" for="summary-company_name">所属公司：</label>
                    <span class="form-control no-borders" id="summary-company_name"><?= \app\modules\user\models\Company::findOne($identity->company_id)->getAttribute('name') ?></span>
                    <div class="help-block"></div>
                </div>
                <br>
                <?= $form->field($searchModel,'start_date')->input('date',['prompt'=>'请选择'])->label('汇总周期：') ?>
                至
                <?= $form->field($searchModel,'end_date')->input('date',['prompt'=>'请选择'])->label(false) ?>
                <div class="btn-group">
                    <a class="btn btn-xs btn-danger" onclick="
                    $('#moneysearch-start_date').val('');
                    $('#moneysearch-end_date').val('');
                ">清除</a>
                    <a class="btn btn-xs btn-primary" onclick="
                    $('#search_hide').click();
                ">汇总</a>
                </div>
                <?= Html::submitButton('search', ['class' => 'hide','id'=>'search_hide']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

    <div class="help-block m-t"></div>
    <?php
        Pjax::begin();
        if($dataProvider){
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭自带分页
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'末页',
            'maxButtonCount' => 9,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header' => '序号'],

            ['label'=>'货币名称','value'=>function($model){
                return $model->name;
            }],
            ['label'=>'总收入','value'=>function($model){
                return number_format($model['gross'],2);
            }],
            ['label'=>'总支出','value'=>function($model){
                return number_format($model['spending'],2);
            }],
            ['label'=>'合计','value'=>function($model){
                $res = $model['gross']-$model['spending'];
                return number_format($res,2);
            }],
        ],
    ]); ?>
    <?php
        }
        Pjax::end();
    ?>
</div>
