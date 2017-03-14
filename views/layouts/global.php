<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\GlobalAsset;

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
<audio class="hide" id="notice-ysp" src="<?= Yii::$app->homeUrl.'/media/yisell_sound_2014040216575424653_88366.mp3' ?>" preload="auto"></audio>
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
        $("#message-count").html(\'.\');
        web_socket.send(1);
    };

    web_socket.onerror = function (e) {
        $("#message-count").addClass(\'red-bg\');
        $("#message-count").html(e.data);
    };

    web_socket.onmessage = function(e){
        var r = JSON.parse(e.data);
        if(r.length!=0){
            var uid = $("#login-user-id").val();
            if(typeof r[uid] != "undefined"){
                $("#message-count").html(r[uid]);
                var myVideo=document.getElementById("notice-ysp");
                if(typeof r.q[uid] != "undefined"){
                    myVideo.play();
                    $.post("'.\yii\helpers\Url::to(['/system/notice/received']).'",{"uid": uid,"_csrf":"'.Yii::$app->request->csrfToken.'"});
                }
            }
        }
    };

    web_socket.onclose = function () {
        $("#message-count").addClass(\'red-bg\');
        $("#message-count").html(\'N\');
    };
');
?>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
