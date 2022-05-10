<?php
require_once "Person.php";
use Workerman\Worker;
use PHPSocketIO\SocketIO;


$io = new SocketIO(3120);
// 当有客户端连接时
$io->user = [];
$dataIds = [];
$io->on('connection', function($socket)use($io){
    $socket->addedUser = false;
    $socket->on('add user', function ($name) use($socket, $io) {
        if ($socket->addedUser)
            return;
        if (array_key_exists($name, $io->user)) {
            $socket->emit('add error',['用户名已经注册，请重新输入啊']);
            return;
        }
        global $dataIds;
        $newIds = $dataIds;
        $dataIds[] = $socket->id;
        $io->user[$name] = new Person($name);
        $socket->addedUser = true;
        $socket->name = $name;
        $newUser = [
            'name' => $name,
            'left' => 0,
            'top'  => 0
        ];
        $data = [];
        foreach ($io->user as $k => $v) {
            [$left, $top] = $v->getPosition();
            $data[] = [
                'name' => $k,
                'left' => $left ?? 0,
                'top' => $top ?? 0
            ];
        }
        //去掉本次登录的socketid，其他id发送添加了一个新用户
        foreach ($newIds ?? [] as $v) {
            $io->to($v)->emit('add new user', $newUser);
        }
        $socket->emit('confirm user',['confirm'=>true, 'name' => $name, 'data' => $data]);
    });

    $socket->on('user move', function ($msg) use($io, $socket) {
        $person = $io->user[$socket->name];
        if ($msg['direct'] == 'left') {
            $person->setPosition($msg['mudi'], $msg['other']);
        }elseif ($msg['direct'] == 'top') {
            $person->setPosition($msg['other'], $msg['mudi']);
        }
        $io->emit('all move', $msg);
    });

    //跑了
    $socket->on('disconnect', function () use($socket, $io) {
        if (!$socket->addedUser)
            return;
        global $dataIds;
        $key = array_search($socket->id, $dataIds);
        unset($dataIds[$key]);
        foreach ($dataIds ?? [] as $v) {
            $io->to($v)->emit('remove leave user', $socket->name);
        }
        unset($io->user[$socket->name]);
    });
});
