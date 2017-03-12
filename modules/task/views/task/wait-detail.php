<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $children */

$this->title = '待接收任务详情';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$identity = (Object) Yii::$app->user->identity;

?>
<div class="task-view">
    <div class="table-responsive">
        <form action="<?= Url::to(['/task/task/receive']) ?>" method="post">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
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
                    <th colspan="8">任务要求</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-left" colspan="8">
                        <p>
                            <?= $model->requirement ?>
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
                            <a href="" class="btn btn-default btn-xs">树形</a>
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

                </tbody>
                <thead>
                <tr>
                    <th colspan="8">执行信息</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="1">执行公司</td>
                    <td colspan="3" class="text-left">
                        <?php
                            if($model['execute']) {
                                echo $model['execute']['company']['name'];
                            }
                        ?>
                    </td>
                    <td colspan="1">操作人 / 时间</td>
                    <td colspan="3" class="text-left"> </td>
                </tr>
                <tr>
                    <td colspan="1">执行价格</td>
                    <td colspan="3" class="text-left">
                        <?php
                            if($model['execute']){
                                $execute_price = $model['execute']->price;
                                // $execute_price = $identity->company_id != $model['product']['company_id'] ? '******' : $model['execute']->price;
                                echo $model['money'][$model['execute']->money_id] . ': ' . $execute_price;
                            }
                        ?>
                    </td>
                    <td colspan="1">预计完成时间</td>
                    <td colspan="3" class="text-left">
                        <div class="form-inline" id="date-task-finish">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input title="" type="text" name="TaskExecuteInfo[finish_time]" class="form-control" value="<?= date('Y-m-d', $_SERVER['REQUEST_TIME']) ?>">
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="form-group">
                <div class="pull-right">
                    <input type="hidden" name="TaskExecuteInfo[task_id]" value="<?= $model->id ?>">
                    <input type="hidden" name="TaskExecuteInfo[money_id]" value="<?= $model['execute']->money_id ?>">
                    <input type="hidden" name="TaskExecuteInfo[price]" value="<?= $model['execute']->price ?>">
                    <input type="hidden" name="TaskExecuteInfo[company_id]" value="<?= $identity->company_id ?>">
                    <?= Html::submitButton('接收任务', ['class' => $model->status==3 ? 'btn btn-primary' : 'hide']) ?>
                </div>
            </div>
        </form>
    </div>

</div>
<?php
$startDate = date('Y-m-d', $_SERVER['REQUEST_TIME']);
$this->registerJsFile('@web/js/global/plugins/datapicker/bootstrap-datepicker.js', ['depends' => 'app\assets\GlobalAsset']);
$this->registerCssFile('@web/css/global/plugins/datapicker/datepicker3.css', ['depends' => 'app\assets\GlobalAsset']);
$this->registerJs('
        $("#date-task-finish .input-group.date").datepicker({
            startDate : \''.$startDate.'\',
            todayBtn: "linked",
            keyboardNavigation: true,
            //forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: "yyyy-mm-dd"
        });
');
?>
