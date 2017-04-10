<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\finance\models\FinanceSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '财务科目管理';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="finance-subject-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('科目列表', ['index'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('垃圾筒', ['trash'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <div class="help-block m-t"></div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="help-block m-t"></div>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

            'subject_name',
            ['label'=>'上级科目','value'=>function($model){
                return $model['superior']['subject_name'] ? $model['superior']['subject_name'] : '';
            }],
            ['label'=>'可用','value'=>function($model){
                if($model->enable==0){
                    return '可用';
                }
                if($model->enable==1){
                    return '停用';
                }
                return null;
            }],
            ['label'=>'状态','value'=>function($model){
                if($model->status==0){
                    return '正常';
                }
                if($model->status==1){
                    return '已作废';
                }
                return null;
            }],
            [
                'header' => '创建人／时间',
                'format' => 'html',
                'value'  => function ($data)
                {
                    return $data['creator']['account'] . '<br>' . $data->create_time;
                },
            ],

            [
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
        <?= $actionId=='index' ? Html::a('新增科目', ['create'], ['class' => 'btn btn-primary btn-sm']) : '' ?>
    </p>
</div>
