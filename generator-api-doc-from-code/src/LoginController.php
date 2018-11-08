<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/11/8
 * Time: 17:43
 */
namespace Api;

/**
 * @apiGroupName 登陆组
 * Class LoginController
 * @package Test
 */
class LoginController
{
    /**
     * Login
     * @apiName 登陆
     * @apiUrl /login
     * @apiMethod POST
     * @apiParam string username 用户姓名
     * @apiParam string password 用户密码
     */
    public function login(){
        echo 'login';
    }

    /**
     * @apiName 注销
     * @apiUrl /logout
     * @apiMethod GET|POST
     */
    public function logout(){
        echo 'logout';
    }
}