<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\NoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的通知';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="notice-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Pjax::begin(['id'=>'countries']); ?>
<!--    <form action="" method="post" id="set-read">-->
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

            'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid'],

            'rowOptions' => function($model) {
                return ['style' => $model->status ==0 ? '' : 'color:#999c9e'];
            },

            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn','name'=>'id'],

                ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

                ['value'=>function($model){
                    return $model->status==0 ? '未读' : '已读';
                },'label'=>'状态'],
                'title',
                'content',
                ['label'=>'收件人/时间','value'=>function($model){
                    return $model['identity']['account'].'<br>'.$model->receive_time;
                },'format'=>'html'],
                ['label'=>'发件人/时间','value'=>function($model){
                    return '系统<br>'.$model->send_time;
                },'format'=>'html'],

                ['class' => 'yii\grid\ActionColumn',
                    'header'=>'操作',
                    'template' => '{user-read}',
                    'buttons' => [
                        'user-read' => function($url,$model){
                            $btn_link = Html::a('已读',
                                $url,
                                [
                                    'data-method' => 'post'
                                ]
                            );
                            return $model->status==0 ? $btn_link : '已读';
                        },
                    ],
                ],
            ],
        ]); ?>
<!--    </form>-->

<?php Pjax::end(); ?>
    <?= Html::a('设为已读', "javascript:void(0);", ['class' => 'btn btn-sm btn-primary gridView']) ?>
</div>
<?php
    $this->registerJs('
        $(".gridView").on("click", function () {
            var keys = $("#grid").yiiGridView("getSelectedRows");
            if(keys.length>0){
                var url = \''.\yii\helpers\Url::to(['/system/notice/read']).'\';
                $.post(url,{ids:keys}).done(function(r){
                    //$.pjax.reload({container:"#countries"});
                    window.location.href = window.location.href;
                });
            }
        });
    ');
?>