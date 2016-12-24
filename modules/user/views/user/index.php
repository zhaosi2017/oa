<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="user-index">
    <p class="btn-group hidden-xs">
        <?= Html::a($this->title.'-列表', ['index'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a($this->title.'-垃圾筒', ['trash'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>
    <p class="btn-group hidden-xs"><?= $actionId=='index' ? Html::a('新增用户', ['create'], ['class' => 'btn btn-link']) : '' ?></p>
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

            'account',

            'company_name',

            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '所属部门',
                'value' => function ($data) {
                    return $data->department_id; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                },
            ],
            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '所属部门',
                'value' => function ($data) {
                    return $data->posts_id; // 如果是数组数据则为 $data['name'] ，例如，使用 SqlDataProvider 的情形。
                },
            ],

            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '状态',
                'value' => function ($data) {
                    return $data->status==0 ? '正常' : '已作废';
                },
            ],

            [
                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
                'header' => '登录许可',
                'value' => function ($data) {
                    return $data->login_permission ? '允许' : '禁止';
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
                'template' => $actionId=='index' ? '{view} {update} {delete}' : '{recover}',
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
<?php Pjax::end(); ?></div>
