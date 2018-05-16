<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/5/16
 * Time: 9:39
 */

require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;

// #### http worker ####
$http_worker = new Worker("http://127.0.0.1:2345");

// 4 processes
$http_worker->count = 4;

// Emitted when data received
$http_worker->onMessage = function($connection, $data)
{
    // $_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES are available
    //var_dump($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES);
    // send data to client
    $connection->send("hello world \n");
};

// run all workers
Worker::runAll();