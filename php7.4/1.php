<?php
/**
 * Date: 2019-12-03
 * Time: 14:24
 */

require_once __DIR__.'/User.php';

$user = new User;

$user->setId(1)->setSex(1);
$user->setUsername('xiaoming');

var_dump($user, $user->getId());
var_dump(json_encode($user));