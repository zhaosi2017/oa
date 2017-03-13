<?php

$table = new swoole_table(1024);
$table->column('fd', swoole_table::TYPE_INT);
$table->create();

$server = new swoole_websocket_server("0.0.0.0", 9501);
$server->table = $table;

$server->on('open', function ($server, $request){
    //echo "server: handshake success with fd{$request->fd}\n";
    $server->table->set($request->fd, array('fd' => $request->fd));//获取客户端id插入table
    /*$res = file_get_contents('http://localhost/oa/web/system/notice/get-push-data');
    $server->push($request->fd, $res);*/
});

$server->on('message', function ($server, $frame){
    //echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $res = file_get_contents('http://localhost/oa/web/system/notice/get-push-data');
    foreach ($server->table as $u) {
        $server->push($u['fd'], $res);//消息广播给所有客户端
    }
});

$server->on('close', function ($ws, $fd){
    $ws->table->del($fd); //从table中删除断开的id
    //echo "client {$fd} closed\n";
});

$server->start();

