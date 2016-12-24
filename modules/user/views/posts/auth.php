<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '权限设置' ;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'auth';
$actionId = Yii::$app->requestedAction->id;
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

        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="3">用户模块</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" width="10%">序号</td>
                <td class="text-center" width="20%">页面名称</td>
                <td>权限</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">用户管理</td>
                <td><label for="view-user"><input id="view-user" type="checkbox" name="Auth[viewUser]" value="viewUser"> 进入</label></td>
            </tr>

            <tr>
                <td class="text-center">2</td>
                <td class="text-center">公司管理</td>
                <td><label for="view-company"><input id="view-company" type="checkbox" name="Auth[viewCompany]" value="viewCompany"> 进入</label></td>
            </tr>

            <tr>
                <td class="text-center">2</td>
                <td class="text-center">部门管理</td>
                <td><label for="view-department"><input id="view-department" type="checkbox" name="Auth[viewDepartment]" value="viewDepartment"> 进入</label></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="text-center">岗位管理</td>
                <td><label for="view-posts"><input id="view-posts" type="checkbox" name="Auth[viewPosts]" value="viewPosts"> 进入</label></td>
            </tr>
            </tbody>
        </table>

        <!--<table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="3">任务模块</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" width="10%">序号</td>
                <td class="text-center" width="20%">页面名称</td>
                <td>权限</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">任务列表</td>
                <td><label for="task-list"><input id="task-list" type="checkbox" name="Task[list]" value="1"> 进入</label></td>
            </tr>

            <tr>
                <td class="text-center">2</td>
                <td class="text-center">新增任务</td>
                <td><label for="task-create"><input id="task-create" type="checkbox" name="Task[create]" value="1"> 进入</label></td>
            </tr>
            </tbody>
        </table>-->

        <div class="form-group">
            <div class="col-sm-offset-9">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        </form>
    </div>


</div>
