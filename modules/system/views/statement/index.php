<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finance\models\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '流水账中心';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="statement-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('账目列表', ['index'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
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

            ['label'=>'流水科目','value'=>function($model){
                return $model['secondFinanceSubject']['subject_name'];
            }],

            ['label'=>'类型','value'=>function($model){
                if($model->type==1){
                    return '公司';
                }
                if($model->type==2){
                    return '任务';
                }
                return null;
            }],
            ['label'=>'关联公司/任务','value'=>function($model){
                if($model->type==1){
                    return $model['associateCompany']['name'];
                }
                if($model->type==2){
                    return $model['task']['number'];
                }
                return null;
            }],
            ['label'=>'状态','value'=>function($model){
                if($model->status==0){
                    return '正常';
                }
                if($model->type==1){
                    return '已作废';
                }
                return null;
            }],
            [
                'label'=>'所属公司',
                'value'=>function($model){
                    return $model['company']['name'];
                }
            ],
            'accounting_date',
            'remark',
            [
                'label'=>'最后修改人',
                'format'=>'html',
                'value'=>function($model){
                    return $model['updater']['account'].'<br>'.$model->update_time;
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
