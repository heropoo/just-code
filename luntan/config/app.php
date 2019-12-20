<?php
/**
 * Date: 2019-12-20
 * Time: 15:29
 */

return [
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=luntan;port=3306',
        'username' => 'root',
        'password' => 'root123456',
        'charset' => 'utf8',
        'tablePrefix' => '',
        'emulatePrepares' => false,
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        ]
    ],
    'redis' => [
        'host'=> 'localhost',
        'port'=> 6379,
        'database'=> 0,
    ]
];