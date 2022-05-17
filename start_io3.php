<?php
require_once "Person.php";
use Workerman\Worker;
use PHPSocketIO\SocketIO;
//单播和广播都实现了
class IOAction
{
    private $group;

    public function __construct()
    {
        $io = new SocketIO(3120);
        $this->run($io);
    }

    private function run($io)
    {
        $io->on('connection', function($socket)use($io){
            $socket->on('add user', function () use($socket){
                $uid = uniqid();
                $this->group['user'][$uid] = [
                    'userId' => $socket->id
                ];
                $socket->join('heihei');
                $socket->emit('confirm user', $uid);
            });

            $socket->on('send user', function ($params) use($socket) {
                $msg= ['theId'=> $params['fromId'], 'mess'=> $params['msg']];
                $socket->to($this->group['user'][$params['toId']]['userId'])->emit('receive user', $msg);
            });

            $socket->on('guangbo user', function ($params) use ($socket) {
                $socket->to('heihei')->emit('get guangbo', $params);
            });
        });
    }
}

new IOAction();
