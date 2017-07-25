<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\product\models\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品分类';
$this->params['breadcrumbs'][] = ['label'=>'产品','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
?>
<div class="product-category-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('分类列表', ['index'], ['class' => $actionId=='trash' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('垃圾筒', ['trash'], ['class' => $actionId=='index' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
            'name',
            ['label' => '上级分类', 'value' =>  function($model){
                $superior = $model['superior']['name'];
                if(!$superior){
                    return '无';
                }
                return $superior;
            }],
            /*[
                'class' => 'yii\grid\DataColumn',
                'header' => '可见',
                'value' => function ($data)
                {
                    $str = '';
                    if($data->avisible & 8){
                        $str .= '直属上级'."\n";
                    }
                    if($data->avisible & 4){
                        $str .= '直属下级'."\n";
                    }
                    if($data->avisible & 2){
                        $str .= '集团内旁枝'."\n";
                    }
                    if($data->avisible & 1){
                        $str .= '集团外公司';
                    }
                    return $str;
                },
            ],*/
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
                    }
                    return $status;
                },
            ],

            ['label'=>'所属公司','value' => 'company.name'],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '创建人／时间',
                'value'  => function ($data)
                {
                    return $data['creator']['account'] . '/' . $data->create_time;
                },
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'header' => '最后修改人／时间',
                'value'  => function ($data)
                {
                    return $data['updater']['account'] . '/' . $data->update_time;
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
    <p class="text-right"><?= $actionId=='index' ? Html::a('新增分类', ['create'], ['class' => 'btn btn-sm btn-primary']) : '' ?></p>
</div>
