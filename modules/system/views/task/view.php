<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $children */

$this->title = '已发任务详情';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$identity = (Object) Yii::$app->user->identity;
?>
<div class="task-view">
    <p class="<?= $model->status!=2 && $model->status!=3 ? 'btn-group hidden-xs' : 'hide' ?>">
        <?= Html::a('任务信息', ['/system/task/view','id'=>$model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('执行反馈', ['/system/task/feedback','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('收付款信息', ['/system/task/pay-receipt-info','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('任务备注', ['/system/task/remark','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
    </p>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th colspan="8">基本信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>任务名称</td>
                <td colspan="7" class="text-left"><?= $model->name . '('.$model->number.')' ?></td>
            </tr>
            <tr>
                <td colspan="1">状态</td>
                <td colspan="3" class="text-left"><?= $model->getStatuses()[$model->status] ?></td>
                <td colspan="1">项目编号</td>
                <td colspan="3" class="text-left"><?= $model->number ?></td>
            </tr>
            <tr>
                <td colspan="1">执行方式</td>
                <td colspan="3" class="text-left"><?= $model->execute_type==1 ? '一次性' : '重复' ?></td>
                <td colspan="1">所属公司</td>
                <td colspan="3" class="text-left"><?= $model['company']['name'] ?></td>
            </tr>
            <tr>
                <td colspan="1">费用结算</td>
                <td colspan="3" class="text-left"><?= $model->fee_settlement==1 ? '全包' : '独立' ?></td>
                <td colspan="1"> </td>
                <td colspan="3"> </td>
            </tr>
            <tr>
                <td colspan="1">创建人 / 时间</td>
                <td colspan="3" class="text-left"><?= $model['creator']['account'] ?> / <?= date('Y-m-d H:i:s', $model->create_time) ?></td>
                <td colspan="1">最后修改人 / 时间</td>
                <td colspan="3" class="text-left"><?= $model['updater']['account'] ?> / <?= date('Y-m-d H:i:s', $model->update_time) ?></td>
            </tr>

            </tbody>
            <thead>
            <tr>
                <th colspan="8">产品信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="1">产品</td>
                <td colspan="3" class="text-left"><?= $model['product']['name'] ?></td>
                <td colspan="1">所属公司</td>
                <td colspan="3" class="text-left"><?= \app\modules\user\models\Company::findOne($model['product']['company_id'])->getAttribute('name') ?></td>
            </tr>
            <tr>
                <td>产品说明</td>
                <td colspan="7" class="text-left"><?= $model['product']['description'] ?></td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="8">客户信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="1">客户</td>
                <td colspan="3" class="text-left"><?= $model->customer_category==1 ? '(外)'.$model['customer']['name'] : '(集)'.$model['group']['name'] ?></td>
                <td colspan="1">级别</td>
                <td colspan="3" class="text-left"><?php
                    $grade = [
                        0 => '未评级',
                        1 => 'A',
                        2 => 'B',
                        3 => 'C',
                        4 => 'D',
                    ];
                    echo $grade[$model->customer_grate];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="text-center text-nowrap">产品价格</td>
                <td colspan="7" class="text-left">
                    <table class="table table-bordered text-center">
                        <tr>
                            <td>货币</td>
                            <td>购买价格</td>
                            <td>成交价格</td>
                        </tr>
                        <?php foreach ($model['deal'] as $item){ ?>
                            <tr>
                                <td><?= $model['money'][$item->money_id] ?></td>
                                <td>
                                    <?= $item->purchase_price ?>
                                </td>
                                <td><?= $item->price ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="8">任务要求</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-left" colspan="8">
                    <p>
                        。。。。。
                    </p>
                    附件：<a href="<?= Url::to(['/task/task/download','attachment' => $model->attachment]) ?>"><?= $model->attachment ?></a>
                </td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th colspan="8">关联任务</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" colspan="8">
                    <div class="btn-group pull-left">
                        <a href="" class="btn btn-primary btn-xs">列表</a>
                        <a href="" class="btn btn-outline btn-default btn-xs">树形</a>
                    </div>
                    <div class="<?= $model->status==4 ? 'btn-group pull-right' : 'hide' ?>">
                        <a href="<?= Url::to(['/task/task/create-child','task_id' => $model->id, 'number' => $model->number]) ?>" data-method="post" class="btn btn-primary btn-xs">新增子任务</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>序号</td>
                <td>任务名称</td>
                <td>任务要求</td>
                <td>上级任务</td>
                <td>状态</td>
                <td>所属公司</td>
                <td>最后修改人／时间</td>
                <td>操作</td>
            </tr>
            <?php

            if(!empty($children)){
                foreach ($children as $i => $child)
                {
                    $res = '<tr><td>'.($i+1).'</td>'
                        .'<td>'.$child['name'].'('.$child['number'].')</td>'
                        .'<td>'.$child['requirement'].'</td>'
                        .'<td>'.$child['sup_number'].'</td>'
                        .'<td>'.$model['statuses'][$child['status']].'</td>'
                        .'<td>'.$child['company_name'].'</td>'
                        .'<td>'.$child['u_account'].' <br>'.date('Y-m-d H:i:s',$child['update_time']).'</td>';

                    if($child['status']>=4){
                        $res .= '<td><a href="'.Url::to(['/task/task/received-detail','id'=>$child['id']]).'">详情</a></td></tr>';
                    }elseif ($child['status']==3){
                        $res .= '<td><a href="'.Url::to(['/task/task/wait-detail','id'=>$child['id']]).'">详情</a></td></tr>';
                    }else{
                        $res .= '<td><a href="'.Url::to(['/task/task/sent-detail','id'=>$child['id']]).'">详情</a></td></tr>';
                    }
                    echo $res;
                }
            }
            ?>
            <!--<tr>
                <td>1</td>
                <td>任务名称(编号)</td>
                <td>。。。。</td>
                <td>编号</td>
                <td>无法执行</td>
                <td>公司名称</td>
                <td>
                    张三 <br>
                    2016-12-12 12:12:12
                </td>
                <td><a href="">详情</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>任务名称(编号)</td>
                <td>。。。。</td>
                <td>编号</td>
                <td>无法执行</td>
                <td>公司名称</td>
                <td>
                    张三 <br>
                    2016-12-12 12:12:12
                </td>
                <td><a href="">详情</a></td>
            </tr>-->
            </tbody>
            <thead>
            <tr>
                <th colspan="8">执行信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="1">执行公司</td>
                <td colspan="3" class="text-left"><?= $model['executeInfo']['company']['name'] ?></td>
                <td colspan="1">操作人 / 时间</td>
                <td colspan="3" class="text-left"><?= $model['executeInfo']['updater']['account'] . '/' . $model['executeInfo']['update_time'] ?></td>
            </tr>
            <tr>
                <td colspan="1">执行价格</td>
                <td colspan="3" class="text-left">
                    <?php
                    $execute_price = $identity->company_id != $model['product']['company_id'] ? '******' : $model['execute']->price;
                    echo $model['money'][$model['execute']->money_id] . ': ' . $execute_price;
                    ?>
                </td>
                <td colspan="1">预计完成时间</td>
                <td colspan="3" class="text-left"> <?= $model['executeInfo']['finish_time'] ?> </td>
            </tr>

            </tbody>
        </table>

        <div class="form-group">
            <?php
            $trash = '<form action="'.Url::to(['/task/feedback/execute']).'" method="post">';
            $trash .= '<div class="form-group p-m">';
            $trash .= '<input type="hidden" name="_csrf" value="'.Yii::$app->request->csrfToken.'">';
            $trash .= '<input type="hidden" id="task_status" name="TaskStatus" value="">';
            $trash .= '<input type="hidden" name="TaskFeedback[task_id]" value="'.$model->id.'">';
            $trash .= '<input type="hidden" name="TaskFeedback[attachment]" value="'.$model->attachment.'">';
            $trash .= '<input type="hidden" id="feedback_type" name="TaskFeedback[type]" value="1">';
            $trash .= '<p>当前操作不可逆转，请务必谨慎操作！(仅限输入500字，必填！)</p>';
            $trash .= '<textarea class="form-control" title="" name="TaskFeedback[content]" rows="5" required maxlength="500" id="trash-content"></textarea>';
            $trash .= '<input type="submit" class="hidden" id="btn-submit" value="submit">';
            $trash .= '</div></form>';
            ?>
        </div>
    </div>

</div>
