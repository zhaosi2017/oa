<?php
use yii\helpers\Url;

$this->title = '垃圾筒';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/user/company.list.js',['depends'=>'app\assets\BootstrapTableAsset']);
$pageNum = isset($pageNum) ? $pageNum : 1;
?>
<div class="row row-lg">
    <div id="company-list" data-type="" class="col-sm-12">

        <div class="btn-group hidden-xs" role="group">
            <a type="button" class="btn btn-primary" href="<?= Url::to(['/user/company/index']) ?>">
                公司列表
            </a>
            <a type="button" class="btn btn-outline btn-default">
                垃圾筒
            </a>
        </div>
        <div class="btn-group hidden-xs" role="group">
            <a href="<?= Url::to(['/user/company/add']) ?>" class="btn btn-w-m btn-link" data-index="8">新增公司</a>
        </div>

        <table id="company-list-table" data-token="<?= Yii::$app->request->csrfToken ?>" data-page-number="<?= 1 ?>" data-url="<?= Url::to(['/user/company/index']) ?>"></table>
    </div>
</div>
