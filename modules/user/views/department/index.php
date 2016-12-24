<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '部门管理';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="department-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="btn-group hidden-xs">
        <?= Html::a($this->title.'-列表', ['index'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a($this->title.'-垃圾筒', ['trash'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <p class="btn-group hidden-xs"><?= $actionId=='index' ? Html::a('新增部门', ['create'], ['class' => 'btn btn-link']) : '' ?></p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
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

            'name',
            'company_name',
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '上级部门',
                'value' => function ($data) {
                    return $data->superior_department_id ? $data->superior_department_id : '无'; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                },
            ],
//            'status',
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '状态',
                'value' => function ($data) {
                    return $data->status==0 ? '正常' : '已作废';
                },
            ],
            // 'create_author_uid',
            // 'update_author_uid',
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '创建人／时间',
                'value' => function ($data) {
                    $author = $data->create_author_uid==0 ? '管理员' : $data->create_author_uid;
                    $time   = $data->create_time;
                    return $author.'/'.$time;
                },
            ],
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '最后修改人／时间',
                'value' => function ($data) {
                    $author = $data->create_author_uid==0 ? '管理员' : $data->create_author_uid;
                    $time   = $data->update_time;
                    return $author.'/'.$time;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => $actionId=='index' ? '{update} {delete}' : '{recover}',
                'buttons' => [
                    'delete' => function($url){
                        return Html::a('<i class="glyphicon glyphicon-trash red-bg"></i>',
                            $url,
                            [
                                'class' => 'btn btn-xs',
                                'data-method' => 'post',
//                                'data-toggle' => 'modal',
                                'data' => ['confirm' => '你确定要作废吗？']
                            ]);
                    },
                    'recover' => function($url){
                        return Html::a('恢复',
                            $url,
                            [
                                'class' => 'btn btn-xs',
                                'data-method' => 'post',
                                'data' => ['confirm' => '你确定要恢复吗?']
                            ]);
                    },

                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
