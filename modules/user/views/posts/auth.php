<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '权限设置' ;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'auth';
$actionId = Yii::$app->requestedAction->id;
$auth = Yii::$app->authManager;
$permissions = $auth->getPermissionsByRole($model->id);
$data = [
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
];
?>
<div class="posts-grid">

    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id='.$model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('权限设置', ['auth?id='.$model->id], ['class' => $actionId=='auth' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
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
            <div class="col-sm-offset-9">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        </form>
    </div>


</div>
