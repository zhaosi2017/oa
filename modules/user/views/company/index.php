<?php
use yii\helpers\Url;

$this->title = '公司列表';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/user/company.list.js',['depends'=>'app\assets\BootstrapTableAsset']);
$pageNum = isset($pageNum) ? $pageNum : 1;
?>
<div class="row row-lg">
    <div id="company-list" data-type="1" class="col-sm-12">

        <div class="btn-group hidden-xs" role="group">
            <a type="button" class="btn btn-outline btn-default">
                公司列表
            </a>
            <a type="button" href="<?= Url::to(['/user/company/trash']) ?>" class="btn btn-primary">
                垃圾筒
            </a>
        </div>
        <div class="btn-group hidden-xs" role="group">
            <a href="<?= Url::to(['/user/company/add']) ?>" class="btn btn-w-m btn-link">新增公司</a>
        </div>

        <table id="company-list-table" data-token="<?= Yii::$app->request->csrfToken ?>" data-page-number="<?= 1 ?>" data-url="<?= Url::to(['/user/company/index']) ?>"></table>
    </div>
</div>
