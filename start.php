<?php
require_once "vendor/autoload.php";
require_once "Person.php";
use Workerman\Worker;
use PHPSocketIO\SocketIO;


//$io = new SocketIO(3120);
//// 当有客户端连接时
//$io->user = [];
//$io->on('connection', function($socket)use($io){
//
//    $socket->addedUser = false;
//    $socket->on('add user', function ($name) use($socket, $io) {
//        if ($socket->addedUser)
//            return;
//        if (array_key_exists($name, $io->user)) {
//            $socket->emit('add error',['用户名已经注册，请重新输入啊']);
//            return;
//        }
//        $io->user[$name] = new Person($name);
//        $socket->addedUser = true;
//        $socket->name = $name;
//        $socket->emit('confirm user',['confirm'=>true, 'name' => $name]);
//        $io->emit('show message', "{$name}来了");
//    });
//
//    $socket->on('see user', function ($msg) use($io) {
//        var_dump($io->user);
//    });
//
//    $socket->on('new message', function ($msg) use($io,$socket) {
//        $returnMsg = $socket->name . ":" . $msg;
//        $io->emit('show message', $returnMsg);
//    });
//    $socket->on('disconnect', function () use($socket, $io) {
//        if (!$socket->addedUser)
//            return;
//        $io->emit('show message', $socket->name.'离开了');
//        unset($io->user[$socket->name]);
//    });
//});

require_once "start_web.php";
require_once "start_io3.php";
Worker::runAll();