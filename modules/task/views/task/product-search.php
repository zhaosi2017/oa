<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品选择';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
$grade = Yii::$app->request->get('grade');
?>
<div class="product-index">

    <p class="btn-group hidden-xs">
        <?= Html::a('搜索查找', ['product-search','grade'=>$grade], ['class' => $actionId=='product-search' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('目录查找', ['product-tree','grade'=>$grade], ['class' => $actionId=='product-tree' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <?php  echo $this->render('_search-product', ['model' => $searchModel]); ?>

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

            [
                'value'=>'category.name',
                'attribute'=>'second_category_id',
                // 'filter'=>$searchModel->filterCategory(),
                'label'=>'产品分类'
            ],

            ['value' => 'company.name', 'label' => '所属公司'],

            ['value' => 'rootCategory.name', 'label' => '根分类'],

            [
                'label' => '购买价格',
                'format' => 'html',
                'value' => function ($data){
                     $grade_price = [
                        1 => 'a_grade_price',
                        2 => 'b_grade_price',
                        3 => 'c_grade_price',
                        4 => 'd_grade_price',
                     ];
                     $str = '';
                     foreach ($data->purchasePrice as $k=>$v){
                         //TODO 根据客户级别显示价格
                         $str .= '<p>'.$data->money[$v->money_id].' : '.$v[$grade_price[$data->grade]].'</p>';
                     }
                     return $str;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{choose}',
                'buttons' => [
                    'choose' => function()
                    {
                        $btn_link = Html::button('选择',
                            [
                                'class' => 'btn btn-primary',
                            ]);
                        return $btn_link;
                    },
                    /*'switch' => function($url, $model){
                        $btn_link = '';
                        switch ($model->status){
                            case 0:
                                $btn_link = Html::a('<i class="glyphicon glyphicon-ban-circle"></i>',
                                    $url . '&status=1',
                                    [
                                        'class' => 'btn btn-xs',
                                        'data-method' => 'post',
                                        'data' => ['confirm' => '你确定要作废吗?']
                                    ]);
                                break;
                            case 1:
                                $btn_link = Html::a('<i class="glyphicon glyphicon-ok"></i>',
                                    $url . '&status=0',
                                    [
                                        'class' => 'btn btn-xs',
                                        'data-method' => 'post',
                                        'data' => ['confirm' => '你确定要恢复吗?']
                                    ]);
                                break;
                        }
                        return $btn_link;
                    },*/

                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
