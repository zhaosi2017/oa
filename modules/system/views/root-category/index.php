<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单据列表';
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

            ['label'=>'根分类名称', 'value'=>function($model){
                return $model->name;
            }],

            ['label'=>'所属公司', 'value'=>function($model){
                return $model['company']['name'];
            }],
            [
                'header' => '可见',
                'value' => function ($data)
                {
                    $str = '';
                    if($data->visible & 8){
                        $str .= '直属上级'."\n";
                    }
                    if($data->visible & 4){
                        $str .= '直属下级'."\n";
                    }
                    if($data->visible & 2){
                        $str .= '集团内旁枝'."\n";
                    }
                    if($data->visible & 1){
                        $str .= '集团外公司';
                    }
                    return $str;
                },
            ],

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
                'template' => '{set}',
                'buttons' => [
                    'set' => function($url){
                        $btn_link = Html::a('编辑',
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
