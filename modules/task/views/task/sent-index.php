<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '已发任务列表';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="task-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('列表', ['sent-index'], ['class' => $actionId=='sent-index' ? 'btn btn-primary': 'btn btn-outline btn-default']) ?>
        <?= Html::a('垃圾筒', ['sent-trash'], ['class' => $actionId=='sent-trash' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
    </p>
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
            'number',
            ['value'=>function($model){
                return $model->name .'('.$model->number.')';
            },'label'=>'任务名称'],

            ['value'=>'requirement','label'=>'任务要求'],
            ['label'=>'上级任务', 'value'=>function($model){
                return $model['product']['second_category_id'];
//                return $model['superior']['name'];
            }],
            ['label'=>'客户', 'value'=>function($model){
                switch ($model->customer_category){
                    case 1:
                        return '(外)' . $model['customer']['name'];
                        break;
                    case 2:
                        return '(集)' . $model['group']['name'];
                        break;
                }
                return false;
            }],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '状态',
                'value'  => function ($model)
                {
                    return $model->statuses[$model->status];
                },
            ],
            ['label'=>'执行方式', 'value' => function($model){
                switch ($model->execute_type){
                    case 1:
                        return '一次性';
                        break;
                    case 2:
                        return '重复';
                        break;
                }
                return false;
            }],
            ['label'=>'费用结算', 'value' => function($model){
                switch ($model->fee_settlement){
                    case 1:
                        return '全包';
                        break;
                    case 2:
                        return '独立';
                        break;
                }
                return false;
            }],
            ['label'=>'所属公司','value'=>function($model){
                return $model['company']['name'];
            }],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => '创建人／时间',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['creator']['account'] . '<br>' . date('Y-m-d H:i:s', $data->create_time);
                },
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '最后修改人／时间',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['updater']['account'] . '<br>' . date('Y-m-d H:i:s', $data->update_time);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{sent-detail}',
                'buttons' => [
                    'sent-detail' => function($url){
                        $btn_link = Html::a('详情',
                            $url,
                            [
                                'data-method' => 'post'
                            ]
                        );
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
