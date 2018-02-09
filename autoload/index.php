<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/2/9
 * Time: 18:41
 */

require_once 'ClassLoader.php';

$loader = new Psr4AutoloaderClass();
$loader->addNamespace('Moon\\', './Moon');
$loader->register();


$connection = new \Moon\Db\Connection();

$model = new \Moon\Db\Model();


var_dump($connection,$model);


