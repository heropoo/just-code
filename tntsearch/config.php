<?php

return [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'test',
    'username'  => 'root',
    'password'  => '',
    'storage'   => __DIR__,
    'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
];