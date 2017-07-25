<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '权限设置' ;
$this->params['breadcrumbs'][] = ['label'=>'用户','url'=>'index'];
$this->params['breadcrumbs'][] = ['label' => '岗位管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->requestedAction->id;
$auth = Yii::$app->authManager;
$permissions = $auth->getPermissionsByRole($model->id);
$data = [
    /*[
        'module' => '任务模块',
        'items' => [
            [
                'page_name' => '已发任务',
                'permission' => ['task/task/sent-index',],//注意顺序
            ],
            [
                'page_name' => '待接收任务',
                'permission' => ['task/task/wait-index',], //顺序可指定
            ],
            [
                'page_name' => '已接收任务',
                'permission' => ['task/task/received-index'],
            ],
        ],

    ],
    [
        'module' => '产品模块',
        'items' => [
            [
                'page_name' => '根分类设置',
                'permission' => ['product/category/root-set',],//注意顺序
            ],
            [
                'page_name' => '产品分类',
                'permission' => ['product/product-category/index',], //顺序可指定
            ],
            [
                'page_name' => '产品管理',
                'permission' => ['product/product/index'],
            ],
        ],

    ],*/
    [
        'module' => '业务模块',
        'items' => [
            [
                'page_name' => '新增任务',
                'permission' => [1 => 'task/task/create',],//注意顺序
            ],
            [
                'page_name' => '任务列表',
                'permission' => ['task/task/index',],//注意顺序
            ],
            [
                'page_name' => '处理中任务',
                'permission' => ['task/task/handle-index',], //顺序可指定
            ],
            [
                'page_name' => '已完成任务',
                'permission' => ['task/task/finished-index'],
            ],
            [
                'page_name' => '已作废任务',
                'permission' => ['task/task/trashed-index'],
            ],
        ],

    ],
    [
        'module' => '事务模块',
        'items' => [
            [
                'page_name' => '根分类设置',
                'permission' => ['product/category/root-set',],//注意顺序
            ],
            [
                'page_name' => '产品分类',
                'permission' => ['product/product-category/index',], //顺序可指定
            ],
            [
                'page_name' => '产品管理',
                'permission' => ['product/product/index'],
            ],
            [
                'page_name' => '处理中任务',
                'permission' => ['product/task/handle-index',],
            ],
            [
                'page_name' => '已完成任务',
                'permission' => ['product/task/finished-index',],
            ],
        ],

    ],
    [
        'module' => '客户模块',
        'items' => [
            [
                'page_name' => '外部客户',
                'permission' => ['customer/customer/index', 'customer/customer/create'],
            ],
            [
                'page_name' => '集团公司评级',
                'permission' => ['customer/group/rate'],
            ],
        ],

    ],
    [
        'module' => '财务模块',
        'items' => [
            [
                'page_name' => '付款单',
                'permission' => ['finance/payment/index'],
            ],
            [
                'page_name' => '收款单',
                'permission' => ['finance/receipt/index'],
            ],
            [
                'page_name' => '公司账目汇总',
                'permission' => ['finance/finance/summary'],
            ],
            [
                'page_name' => '流水账',
                'permission' => ['finance/statement/index'],
            ],
        ],

    ],
    [
        'module' => '用户模块',
        'items' => [
            [
                'page_name' => '用户管理',
                'permission' => ['user/user/index', 'user/user/create', 'user/user/update', 'user/user/switch'],//注意顺序
            ],
            [
                'page_name' => '公司管理',
                'permission' => ['user/company/index', 3=>'user/company/switch'], //顺序可指定
            ],
            [
                'page_name' => '部门管理',
                'permission' => ['user/department/index'],
            ],
            [
                'page_name' => '岗位管理',
                'permission' => ['user/posts/index'],
            ],
        ],

    ],
    [
        'module' => '系统模块',
        'items' => [
            [
                'page_name' => '任务中心',
                'permission' => ['system/task/index'],//注意顺序
            ],
            [
                'page_name' => '付款中心',
                'permission' => ['system/payment/index'], //顺序可指定
            ],
            [
                'page_name' => '收款中心',
                'permission' => ['system/receipt/index'],
            ],
            [
                'page_name' => '根分类列表',
                'permission' => ['system/root-category/index'],
            ],
            [
                'page_name' => '产品分类中心',
                'permission' => ['system/product-category/index'],
            ],
            [
                'page_name' => '产品中心',
                'permission' => ['system/product/index'],
            ],
            [
                'page_name' => '集团公司级别表',
                'permission' => ['system/group/rate'],
            ],
            [
                'page_name' => '外部客户管理',
                'permission' => ['system/customer/index'],
            ],
            [
                'page_name' => '货币管理',
                'permission' => ['system/money/index'],
            ],
            [
                'page_name' => '财务科目管理',
                'permission' => ['system/finance-subject/index'],
            ],
            [
                'page_name' => '流水账中心',
                'permission' => ['system/statement/index'],
            ],
            [
                'page_name' => '公司账目中心',
                'permission' => ['system/finance/summary'],
            ],
            [
                'page_name' => '通知中心',
                'permission' => ['system/notice/index'],
            ],
            [
                'page_name' => '登录记录',
                'permission' => ['system/login/record'],
            ],
            [
                'page_name' => 'IP登录锁定',
                'permission' => ['system/login/ip-lock'],
            ],
        ],

    ],

];
?>
<div class="posts-grid">

    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='auth' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('权限设置', ['auth?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <div class="table-responsive">
        <form action="" method="post" id="w0">
            <input type="hidden" name="Posts[id]" value="<?= $model->id ?>">
            <input type="hidden" name="_csrf" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <?php foreach ($data as $k=>$v){ ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="3"><?= $v['module'] ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" width="10%">序号</td>
                <td class="text-center" width="20%">页面名称</td>
                <td>权限</td>
            </tr>
            <?php foreach ($v['items'] as $key=>$val){ ?>
            <tr>
                <td class="text-center"><?= ++$key; ?></td>
                <td class="text-center"><?= $val['page_name'] ?></td>
                <td>
                    <?php foreach ($val['permission'] as $i=>$permission){ ?>
                    <label for="<?= 'I-'.$k.$key.$i ?>">
                        <input id="<?= 'I-'.$k.$key.$i ?>" <?= array_key_exists($permission, $permissions) ? 'checked="checked"' : ' ' ?> type="checkbox" name="Auth[<?= 'I-'.$k.$key.$i ?>]" value="<?= $permission ?>">
                        <?php
                            $label = '进入';
                            switch ($i){
                                case 1:
                                    $label = '创建';
                                    break;
                                case 2:
                                    $label = '编辑';
                                    break;
                                case 3:
                                    $label = '作废/恢复';
                                    break;
                            }
                            echo $label . '&nbsp;&nbsp;&nbsp;&nbsp;';
                        ?>
                    </label>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>

        </table>
        <?php } ?>

        <div class="form-group">
            <div class="text-right">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        </form>
    </div>


</div>
