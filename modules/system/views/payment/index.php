<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '付款中心';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="payment-index">

    <div class="help-block m-t"></div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
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
            'pay_bill_no',
            ['value'=>function($model){
                switch ($model->status){
                    case 0:
                        return '待付款';break;
                    case 1:
                        return '已作废';break;
                    case 2:
                        return '已付款';break;
                }
                return false;
            },'label'=>'状态'],

            ['label'=>'执行公司','value'=>function($model){
                return $model['executeCompany']['name'];
            }],

            ['label'=>'付款金额','value'=>function($model){
                $res = '';
                $res .= $model['task']['money'][$model['executeInfo']['money_id']];
                $res .= ':'.$model['executeInfo']['price'];
                return $res;
            },'format'=>'html'],

            ['label'=>'所属任务','value'=>function($model){
                return $model['task']['number'];
            }],

            ['label'=>'付款公司','value'=>function($model){
                return $model['payCompany']['name'];
            }],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '创建人／时间',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['creator']['account'] . '<br>' .  $data->create_time;
                },
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '最后修改人／时间',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['updater']['account'] . '<br>' . $data->update_time;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url){
                        $btn_link = Html::a('详情', $url);
                        return $btn_link;
                    },

                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <p class="<?= $actionId=='sent-index' ? 'btn-group pull-right' : 'hide' ?>">
        <?= Html::a('新增任务', ['create'], ['class'=>'btn btn-sm btn-primary']) ?>
    </p>

</div>
