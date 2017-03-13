<?php

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskPayInfo */

$this->title = '付款单详情';
$this->params['breadcrumbs'][] = ['label'=>'财务','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '付款单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pay-info-view">
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr><th colspan="4">基本信息</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>付款单编号</td>
                    <td class="text-left"><?= $model->pay_bill_no ?></td>
                    <td>状态</td>
                    <td class="text-left"><?php
                        switch ($model->status){
                            case 0:
                                echo '待付款';
                                break;
                            case 1:
                                echo '已作废';
                                break;
                            case 2:
                                echo '已付款';
                                break;
                        }
                        ?></td>
                </tr>
                <tr>
                    <td>所属任务</td>
                    <td class="text-left"><?= $model['task']['name'] . '('.$model['task']['number'].')' ?></td>
                    <td>付款公司</td>
                    <td class="text-left"><?= $model['payCompany']['name'] ?></td>
                </tr>
                <tr>
                    <td>执行公司</td>
                    <td class="text-left"><?= $model['executeCompany']['name'] ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>创建人／时间</td>
                    <td class="text-left"><?= $model['creator']['account'] . '/' . $model->create_time ?></td>
                    <td>最后修改人／时间</td>
                    <td class="text-left"><?= $model['updater']['account'] . '/' . $model->update_time ?></td>
                </tr>
            </tbody>
            <thead>
                <tr><th colspan="4">付款金额</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">货币</td>
                    <td colspan="2">实际应付</td>
                </tr>
                <?php
                    /*foreach ($model['task']['deal'] as $item){
                        $tr  = '<tr>';
                        $tr .= '<td colspan="2">'.$model['task']['money'][$item['money_id']].'</td>';
                        $tr .= '<td colspan="2">'.$item['price'].'</td>';
                        echo $tr;
                    }*/
                    echo '<tr><td colspan="2">'.$model['task']['money'][$model['executeInfo']['money_id']].'</td><td colspan="2">'.$model['executeInfo']['price'].'</td></tr>';
                ?>
            </tbody>
        </table>
    </div>
</div>
