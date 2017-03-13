<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finance\models\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '锁定列表';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="statement-index">

    <div class="help-block m-t"></div>
    <?php  echo $this->render('_search_ip_lock', ['model' => $searchModel]); ?>
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

            ['label'=>'IP','value'=>function($model){
                return $model->login_ip;
            }],

            ['label'=>'状态','value'=>function($model){
                if($model->status==1){
                    return '已解锁';
                }
                if($model->status==4){
                    return '锁定中';
                }
                return null;
            }],

            ['label'=>'登录时间','value'=>function($model){
                return $model->login_time;
            }],

            ['label'=>'解锁时间','value'=>function($model){
                return $model->unlock_time;
            }],

            ['label'=>'操作人/时间','format'=>'html','value'=>function($model){
                return $model['operator']['account'] .'<br>'. $model->login_time;
            }],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{switch}',
                'buttons' => [
                    'switch' => function($url,$model){
                        if($model->status==4){
                            $btn_link = Html::a('解锁',
                                $url . '&status=1',
                                [
                                    'data-method' => 'post',
                                    'data' => ['confirm' => '你确定要解锁吗?']
                                ]);
                        }else{
                            $btn_link = '解锁';
                        }
                        return $btn_link;
                    },

                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
