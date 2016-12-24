<?php
use yii\helpers\Url;


$this->title = '主页';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerCssFile('@web/css/global/font-awesome.min.css');
/*$this->registerJsFile('@web/js/global/plugins/metisMenu/jquery.metisMenu.js');
$this->registerJsFile('@web/js/global/plugins/slimscroll/jquery.slimscroll.min.js');
$this->registerJsFile('@web/js/global/plugins/pace/pace.min.js');
$this->registerJsFile('@web/js/home/contabs.js');
$this->registerJsFile('@web/js/home/hplus.js');*/
?>
<iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?= Url::to(['main/index']) ?>" frameborder="0" data-id="home/main/index" seamless></iframe>