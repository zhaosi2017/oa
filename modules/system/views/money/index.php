<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\MoneySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '货币管理';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="money-index">
    <p class="btn-group hidden-xs">
        <?= Html::a('列表', ['index'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('垃圾筒', ['trash'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <p class="btn-group hidden-xs"><?= $actionId=='index' ? Html::a('新增货币', ['create'], ['class' => 'btn btn-link']) : '' ?></p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭自带分页
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'末页',
            'maxButtonCount' => 9,
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],

            'name',
            [
                'class' => 'yii\grid\DataColumn',
                'header' => '状态',
                'value'  => function ($data)
                {
                    $status = '';
                    switch ($data->enable){
                        case 0:
                            $status = '可用';
                            break;
                        case 1:
                            $status = '停用';
                    }
                    return $status;
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => '状态',
                'value'  => function ($data)
                {
                    $status = '';
                    switch ($data->status){
                        case 0:
                            $status = '正常';
                            break;
                        case 1:
                            $status = '已作废';
                    }
                    return $status;
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'label' => '创建人／时间',
                'attribute' => 'creator_account',
                'format' => 'raw',
                'value'  => function ($data)
                {
                    return $data['creator']['account'] . '<br>' . $data->create_time;
                },
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'label' => '最后修改人／时间',
                'attribute' => 'updater_account',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['updater']['account'] . '<br>' . $data->update_time;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{update} {switch}',
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
</div>
