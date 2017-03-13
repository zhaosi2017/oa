<?php

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\TaskCollectionInfo */

$this->title = '收款单详情';
$this->params['breadcrumbs'][] = ['label' => 'Task Pay Infos', 'url' => ['index']];
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
                <td>收款单编号</td>
                <td class="text-left"><?= $model->receipt_no ?></td>
                <td>状态</td>
                <td class="text-left"><?php
                    switch ($model->status){
                        case 0:
                            echo '待收款';
                            break;
                        case 1:
                            echo '已作废';
                            break;
                        case 2:
                            echo '已收款';
                            break;
                    }
                    ?></td>
            </tr>
            <tr>
                <td>所属任务</td>
                <td class="text-left"><?= $model['task']['name'] . '('.$model['task']['number'].')' ?></td>
                <td>收款公司</td>
                <td class="text-left"><?= $model['receiptCompany']['name'] ?></td>
            </tr>
            <tr>
                <td>收款方式</td>
                <td class="text-left"><?php
                    if($model->type==1){
                        echo '现金收取';
                    }
                    if($model->type==2){
                        echo '集团托收';
                    }
                ?></td>
                <td>客户</td>
                <td class="text-left">
                    <?php
                        if($model->customer_category==1){
                            echo '(外)'.$model['customer']['name'];
                        }
                        if($model->customer_category==2){
                            echo '(集)'.$model['group']['name'];
                        }
                    ?>
                </td>
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
            foreach ($model['task']['deal'] as $item){
                $tr  = '<tr>';
                $tr .= '<td colspan="2">'.$model['task']['money'][$item['money_id']].'</td>';
                $tr .= '<td colspan="2">'.$item['price'].'</td>';
                echo $tr;
            }
            ?>
            </tbody>
            <thead>
                <tr><th colspan="8">收款财务备注</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8" class="text-left">
                        <?php if($model->status==0){ ?>
                        <p>当前操作不可逆转，请务必谨慎操作！(仅限输入500字，必填！)</p>
                        <form action="<?= \yii\helpers\Url::to(['/finance/receipt/remark','id'=>$model->id]) ?>" method="post">
                            <label for="">收款方式：</label>
                            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="TaskCollectionInfo[status]" value="2">
                            <label for="type_one"><input type="radio" checked id="type_one" name="TaskCollectionInfo[type]" value="1">现金收取</label>
                            <label for="type_two"><input type="radio" id="type_two" name="TaskCollectionInfo[type]" value="2">集团托收</label>
                            <br>
                            <textarea title="remark" required class="full-width fa-text-height" rows="10" name="TaskCollectionInfo[remark]"></textarea>
                            <br>
                            <div class="text-right">
                                <input class="btn btn-primary btn-sm" type="submit" value="确认收款">
                            </div>
                        </form>
                        <?php }
                            if($model->status==2){
                                echo $model->remark;
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
