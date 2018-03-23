<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/2/9
 * Time: 18:41
 */

require_once 'ClassLoader.php';

$loader = new Psr4AutoloaderClass();
$loader->addNamespace('Test\\', './Moon');
$loader->register();


$connection = new \Test\Db\Connection();

$model = new \Test\Db\Model();


var_dump($connection,$model);


