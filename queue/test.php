<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2019/3/29
 * Time: 16:06
 */

require 'Queue.php';

$queue = new Queue();

var_dump($queue->pop('list_1'));

$queue->push('list_1', '1');
$queue->push('list_1', '2');
$queue->push('list_1', '3');

var_dump($queue->pop('list_1'));
var_dump($queue->pop('list_1'));
var_dump($queue->pop('list_1'));
var_dump($queue->pop('list_1'));
