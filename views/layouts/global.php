<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
use app\assets\GlobalAsset;
//use yii\bootstrap\Alert;

GlobalAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title><?= $this->title ?></title>

    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

<!--    <link rel="shortcut icon" href="favicon.ico">-->
    <?= Html::csrfMetaTags() ?>

    <?php $this->head() ?>
</head>

<body class="fixed-sidebar full-height-layout gray-bg pace-done" style="overflow:hidden">
<?php
/*if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success no-margins', //这里是提示框的class
            // 'style' => 'z-index:9999;position:fixed;width:100%',
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}
if( Yii::$app->getSession()->hasFlash('error') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning no-margins',
        ],
        'body' => Yii::$app->getSession()->getFlash('error'),
    ]);
}
if( Yii::$app->getSession()->hasFlash('info') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-info no-margins',
        ],
        'body' => Yii::$app->getSession()->getFlash('info'),
    ]);
}*/
?>
<?php $this->beginBody() ?>
    <?= isset($content) ? $content : ''  ?>
</body>
<?php
function get_server_ip() {
    if (isset($_SERVER)) {
        if($_SERVER['SERVER_ADDR']) {
            $server_ip = $_SERVER['SERVER_ADDR'];
        } else {
            $server_ip = $_SERVER['LOCAL_ADDR'];
        }
        if($_SERVER['SERVER_NAME']){
            $server_ip = $_SERVER['SERVER_NAME'];
        }
    } else {
        $server_ip = getenv('SERVER_ADDR');
    }
    return $server_ip;
}
$this->registerJs('
    web_socket = new WebSocket("ws://'.get_server_ip().':9501/");
    web_socket.onopen = function() {
        $("#message-count").html(\'\');
    };

    web_socket.onerror = function (e) {
        $("#message-count").addClass(\'red-bg\');
        $("#message-count").html(e.data);
    };

    web_socket.onmessage = function(e){
        var r = JSON.parse(e.data);
        if(r.length!=0){
            var uid = $("#login-user-id").val();
            $("#message-count").html(r[uid]);
        }
    };

    web_socket.onclose = function () {
        $("#message-count").addClass(\'red-bg\');
        $("#message-count").html(\'N\');
    };
');
?>
<!--<script>
    web_socket = new WebSocket("ws://127.0.0.1:9501/");
    web_socket.onopen = function() {
        $("#message-count").html('9');
    };

    web_socket.onerror = function (e) {
        $("#message-count").addClass('red-bg');
        $("#message-count").html(e.data);
    };

    web_socket.onmessage = function(e){
        $("#message-count").html(e.data);
    };

    web_socket.onclose = function () {
        $("#message-count").addClass('red-bg');
        $("#message-count").html('N');
    };
</script>-->
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
