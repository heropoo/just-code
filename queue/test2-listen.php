<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2019/3/29
 * Time: 16:06
 */

require_once 'vendor/autoload.php';
require 'RedisQueue.php';

$client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => 6379
    ],
    [
        'replication' => 'sentinel',
        'service' => 'master',
        'parameters' => [
            'password' => '123456',
            'database' => 10,
        ],
    ]
);

$queue = new RedisQueue($client);


while (true){
    $res = $queue->receive('list_1');
    if(empty($res)){
        sleep(1);
    }
    var_dump($res);
}
//var_dump($queue->receive('list_1'));
//
//$res = $queue->push('list_1', '1---', 10);
//$res = $queue->push('list_1', '2---');

//$queue->push('list_1', '2');
//$queue->push('list_1', '3');

//var_dump($queue->pop('list_1'));
//var_dump($queue->pop('list_1'));
//var_dump($queue->pop('list_1'));
//var_dump($queue->pop('list_1'));
