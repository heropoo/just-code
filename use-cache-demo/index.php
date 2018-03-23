<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/3/23
 * Time: 10:41
 */

require 'vendor/autoload.php';


$client = new \Predis\Client('tcp://127.0.0.1:6379');

$db = new \Moon\Db\Connection([
    'dsn' => 'mysql:host=localhost;dbname=test;port=3306;charset=utf8',
    'username' => 'root',
    'password' => 'root',
]);

$sql = "select * from z_area where area_id < 11";

$key = md5($sql);

$list = $client->get($key);
if(empty($list)){
    echo '查库';
    $list = $db->fetchAll($sql);
    $client->setex($key, 3600, json_encode($list));
}else{
    echo('走缓存了');
    $list = json_decode($list, 1);
}

echo '<pre>';
var_dump($list);



