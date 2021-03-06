<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\TaskFeedbackSearch */
/* @var $model app\modules\task\models\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '已发任务详情';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;

?>
<div class="task-index">
    <p class="btn-group hidden-xs">
        <?= Html::a('任务信息', ['/system/task/view','id'=>$model->id], ['class' => 'btn btn-outline btn-default']) ?>
        <?= Html::a('执行反馈', ['/system/task/feedback','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('收付款信息', ['/system/task/pay-receipt-info','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('任务备注', ['/system/task/remark','id'=>$model->id], ['class' =>  'btn btn-primary']) ?>
    </p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>执行反馈</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="btn-group">
                    <?= Html::a('备注列表', ['remark','id'=>$model->id], ['class' => $actionId=='remark' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
                    <?= Html::a('垃圾筒', ['remark-trash','id'=>$model->id], ['class' => $actionId=='remark-trash' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
                </div>

                <?php
                $form  = '<form action="'.\yii\helpers\Url::to(['/task/remark/create']).'" method="post">';
                $form .= '<div class="form-group p-m">';
                $form .= '<input type="hidden" name="_csrf" value="'.Yii::$app->request->csrfToken.'">';
                $form .= '<input type="hidden" name="TaskRemark[task_id]" value="'.$model->id.'">';
                $form .= '<label for="trash-content">当前操作不可逆转，请务必谨慎操作！(仅限输入500字，必填！)</label>';
                $form .= '<textarea class="form-control" title="" name="TaskRemark[content]" rows="5" required maxlength="500" id="trash-content"></textarea>';
                $form .= '<input type="submit" class="hidden" id="btn-submit" value="submit">';
                $form .= '</div></form>';
                ?>

            </td>
        </tr>
        <?php Pjax::begin(); ?>
        <tr>
            <td>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
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
                            'label' => '创建人 / 时间',
                            'attribute' => 'create_time',
                            'format' => 'html',
                            'value'  => function ($data)
                            {
                                return $data['creator']['account'] . '<br>' . $data->create_time;
                            },
                        ],

                        ['label' => '备注内容', 'format' => 'html', 'value' => function($model){
                            return $model->content;
                        }, 'options' => ['width' => '60%']],
                    ],
                ]); ?>
            </td>
        </tr>
        <?php Pjax::end(); ?>
        </tbody>
    </table>
</div>
