<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\TaskFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '已发任务详情';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="task-trash">

    <p class="btn-group hidden-xs">
        <?= Html::a('任务信息', ['/task/task/detail'], ['class' => 'btn btn-outline btn-default']) ?>
        <?= Html::a('执行反馈', ['/task/feedback/index'], ['class' =>  'btn btn-primary']) ?>
        <?= Html::a('收付款信息', ['/task/pay-info/detail'], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('任务备注', ['task-remark'], ['class' =>  'btn btn-outline btn-default']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>执行反馈</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="btn-group">
                    <?= Html::a('列表', ['index'], ['class' => 'btn btn-outline btn-default']) ?>
                    <?= Html::a('垃圾筒', ['trash'], ['class' =>  'btn btn-primary']) ?>
                </div>
                <div class="form-group pull-right">
                    <?= Html::a('新增执行反馈', ['create'], ['class'=>'btn btn-primary']) ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
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

                        [
                            'class' => 'yii\grid\DataColumn',
                            'label' => '创建人 / 时间',
                            'attribute' => 'create_time',
                            'format' => 'html',
                            'value'  => function ($data)
                            {
                                return $data['creator']['account'] . '<br>' . date('Y-m-d H:i:s', $data->create_time);
                            },
                        ],

                        ['label' => '反馈内容', 'format' => 'html', 'value' => function($model){
                            return '类型：' . $model['types'][$model->type] .'<br>'
                                . $model->content . '<br>'
                                . '附件：' . $model->attachment ;
                        }, 'options' => ['width' => '60%']],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{switch}',
                            'buttons' => [
                                'switch' => function($url, $model){
                                    $btn_link = '';
                                    switch ($model->status){
                                        case 0:
                                            $btn_link = Html::a('<i class="glyphicon glyphicon-ban-circle"></i>',
                                                $url . '&status=1',
                                                [
                                                    'class' => 'btn btn-xs',
                                                    'data-method' => 'post',
                                                    'data' => ['confirm' => '你确定要作废吗?']
                                                ]);
                                            break;
                                        case 1:
                                            $btn_link = Html::a('<i class="glyphicon glyphicon-ok"></i>',
                                                $url . '&status=0',
                                                [
                                                    'class' => 'btn btn-xs',
                                                    'data-method' => 'post',
                                                    'data' => ['confirm' => '你确定要恢复吗?']
                                                ]);
                                            break;
                                    }
                                    return $btn_link;
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
