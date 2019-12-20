<?php
/**
 * Date: 2019-12-20
 * Time: 16:11
 */

return [
    'namespace'=> 'App\Controllers',
    'map' => [
        '/' => 'IndexController@index', //首页
        '/list' => 'IndexController@boardList', //首页列表数据
        '/create' => 'IndexController@create', //创建
        '/save' => 'IndexController@save', //保存
        '/delete' => 'IndexController@delete', //删除
    ]
];