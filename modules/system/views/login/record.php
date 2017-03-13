<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finance\models\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '登录记录';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="statement-index">

    <div class="help-block m-t"></div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="help-block m-t"></div>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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

            ['label'=>'用户名称','value'=>function($model){
                return $model['user']['account'];
            }],

            ['label'=>'状态','value'=>function($model){
                return $model['statuses'][$model->status];
            }],
            ['label'=>'登录时间','value'=>function($model){
                return $model->login_time;
            }],
            ['label'=>'登录IP','value'=>function($model){
                return $model->login_ip;
            }],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
