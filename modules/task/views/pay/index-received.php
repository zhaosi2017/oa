<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $collection */
/* @var $pay_model */

$this->title = '收付款信息';
$this->params['breadcrumbs'][] = ['label' => '任务', 'url' => ['/task/task/received-index']];
$this->params['breadcrumbs'][] = ['label' => '已接收任务', 'url' => ['/task/task/received-index']];
$this->params['breadcrumbs'][] = $this->title;
$identity = (Object) Yii::$app->user->identity;

?>
<div class="pay-info">
    <p class="<?= $model->status!=2 && $model->status!=3 ? 'btn-group hidden-xs' : 'hide' ?>">
        <?= Html::a('任务信息', ['/task/task/received-detail','id'=>$model->id], ['class' => 'btn btn-outline btn-default']) ?>
        <?= Html::a('执行反馈', ['/task/feedback/index-received','id'=>$model->id], ['class' =>  'btn btn-outline btn-default']) ?>
        <?= Html::a('收付款信息', ['/task/pay/index-received','id'=>$model->id], ['class' =>  'btn btn-primary']) ?>
    </p>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th colspan="10">收款单</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>序号</td>
                <td>收款单编号</td>
                <td>状态</td>
                <td>收款方式</td>
                <td>客户</td>
                <td>所属任务</td>
                <td>所属公司</td>
                <td>创建人 / 时间</td>
                <td>最后修改人 / 时间</td>
                <td>操作</td>
            </tr>
            <?php
                foreach ($collection as $i => $value){
                    $tr  = '<td>'. ++$i .'</td>';
                    $tr .= '<td>'. $value->receipt_no .'</td>';
                    $tr .= '<td>'. ($value->status!=2 ? '待收款' : '已收款') .'</td>';
                    $tr .= '<td>'. ($value->type==1 ? '现金收取' : '集团托收') .'</td>';
                    $tr .= '<td>'. ($model->customer_category==1 ? '(外)'.$model['customer']['name'] : '(集)'.$model['group']['name']) .'</td>';
                    $tr .= '<td>'. $model->number .'</td>';
                    $tr .= '<td>'. $model['company']['name'] .'</td>';
                    $tr .= '<td>'. $value['creator']['account'] .'<br>'. $value['create_time'] .'</td>';
                    $tr .= '<td>'. $value['updater']['account'] .'<br>'. $value['update_time'] .'</td>';
                    $tr .= '<td><a href="'.\yii\helpers\Url::to(['/finance/receipt/view','id'=>$value->id]).'">详情</a></td>';
                    echo $tr;
                }
            ?>
        </table>

        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th colspan="10">付款单</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>序号</td>
                <td>付款单编号</td>
                <td>状态</td>
                <td>执行公司</td>
                <td>所属任务</td>
                <td>所属公司</td>
                <td>创建人 / 时间</td>
                <td>最后修改人 / 时间</td>
                <td>操作</td>
            </tr>
            <?php
                foreach ($pay_model as $i => $value){
                    $tr  = '<td>'. ++$i .'</td>';
                    $tr .= '<td>'. $value->pay_bill_no .'</td>';
                    $tr .= '<td>'. ($value->status!=2 ? '待付款' : '已付款') .'</td>';
                    $tr .= '<td>'. $model['executeCompany']['name'] .'</td>';
                    $tr .= '<td>'. $model->number .'</td>';
                    $tr .= '<td>'. $model['company']['name'] .'</td>';
                    $tr .= '<td>'. $value['creator']['account'] .'<br>'. $value['create_time'] .'</td>';
                    $tr .= '<td>'. $value['updater']['account'] .'<br>'. $value['update_time'] .'</td>';
                    $tr .= '<td><a href="'.\yii\helpers\Url::to(['/finance/payment/view','id'=>$value->id]).'">详情</a></td>';
                    echo $tr;
                }
            ?>
        </table>
    </div>
</div>
