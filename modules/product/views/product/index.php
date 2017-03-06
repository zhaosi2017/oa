<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\product\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品管理';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="product-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('产品列表', ['index'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('垃圾筒', ['trash'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <div class="help-block m-t"></div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="help-block m-t"></div>
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
                'header' => '产品名称',
//                'headerOptions' => ['width' => '120'] ,
                'attribute' => 'name',
                'value'  => function ($data)
                {
                    return $data->name . '('.$data->number.')';
                },
            ],

            ['value'=>'category.name', 'label'=>'产品分类'],

            [
                'class'=>'yii\grid\DataColumn',
                'filter' => ['1'=>'停用','0'=>'可用'],
                /*'filter' => Html::activeDropDownList($searchModel,
                    'enable',['1'=>'停用','0'=>'可用'],
                    ['prompt'=>'全部']),*/
                'label'=>'可用',
                'attribute'=>'enable',
                'value'  => function ($data)
                {
                    $status = '';
                    switch ($data->enable){
                        case 0:
                            $status = '可用';
                            break;
                        case 1:
                            $status = '停用';
                            break;
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
                            break;
                    }
                    return $status;
                },
            ],
            ['value' => 'company.name', 'label' => '所属公司'],
            ['label' => '产品说明', 'value' => 'description'],
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
                    'update' => function($url){
                        return Html::a('编辑',$url);
                    },
                    'switch' => function($url, $model){
                        $btn_link = '';
                        switch ($model->status){
                            case 0:
                                $btn_link = Html::a('作废',
                                    $url . '&status=1',
                                    [
                                        'class' => 'btn btn-xs',
                                        'style' => 'color:red',
                                        'data-method' => 'post',
                                        'data' => ['confirm' => '你确定要作废吗?']
                                    ]);
                                break;
                            case 1:
                                $btn_link = Html::a('恢复',
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
    <p class="text-right">
        <?= $actionId=='index' ? Html::a('新增产品', ['create'], ['class' => 'btn btn-sm btn-primary']) : '' ?>
    </p>
</div>
