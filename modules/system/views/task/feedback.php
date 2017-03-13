<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\TaskFeedbackSearch */
/* @var $model app\modules\task\models\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '执行反馈';
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;

?>
<div class="task-index">
    <p class="btn-group hidden-xs">
        <?= Html::a('任务信息', ['/system/task/view','id'=>$model->id], ['class' => 'btn btn-outline btn-default']) ?>
        <?= Html::a('执行反馈', ['/system/task/feedback','id'=>$model->id], ['class' =>  'btn btn-primary']) ?>
        <?= Html::a('收付款信息', ['/system/task/pay-receipt-info','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('任务备注', ['/system/task/remark','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
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
                        <?= Html::a('反馈列表', ['feedback','id'=>$model->id], ['class' => $actionId=='feedback' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
                        <?= Html::a('垃圾筒', ['feedback-trash','id'=>$model->id], ['class' => $actionId=='feedback-trash' ? 'btn btn-primary' : 'btn btn-outline btn-default']) ?>
                    </div>

                    <?php
                        $form = '<form action="'.\yii\helpers\Url::to(['/task/feedback/execute']).'" method="post">';
                        $form .= '<div class="form-group p-m">';
                        $form .= '<input type="hidden" name="_csrf" value="'.Yii::$app->request->csrfToken.'">';
                        $form .= '<input type="hidden" id="task_status" name="TaskStatus" value="">';
                        $form .= '<input type="hidden" name="TaskFeedback[task_id]" value="'.$model->id.'">';
                        $form .= '<input type="hidden" name="TaskFeedback[attachment]" value="'.$model->attachment.'">';
                        $form .= '<input type="hidden" id="feedback_type" name="TaskFeedback[type]" value="0">';
                        $form .= '<label for="trash-content">当前操作不可逆转，请务必谨慎操作！(仅限输入500字，必填！)</label>';
                        $form .= '<textarea class="form-control" title="" name="TaskFeedback[content]" rows="5" required maxlength="500" id="trash-content"></textarea>';
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
                                    return $data['creator']['account'] . '<br>' . date('Y-m-d H:i:s', $data->create_time);
                                },
                            ],

                            ['label' => '反馈内容', 'format' => 'html', 'value' => function($model){
                                return '类型：' . $model['types'][$model->type] .'<br>'
                                    . $model->content . '<br>'
                                    . '附件：<a href="'.\yii\helpers\Url::to(['/task/task/download','attachment' => $model->attachment]).'">' . $model->attachment .'</a>' ;
                            }, 'options' => ['width' => '60%']],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '{switch}',
                                'buttons' => [
                                    'switch' => function($url, $model){
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
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </td>
            </tr>
            <?php Pjax::end(); ?>
            </tbody>
        </table>
</div>
