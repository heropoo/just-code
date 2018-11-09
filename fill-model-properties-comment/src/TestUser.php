<?php
namespace App\Models;

/**
 * Class App\Models\TestUser 
 * @property integer $id 
 * @property string $username 用户名
 * @property string $email E-mail
 * @property string $password 密码
 * @property string $salt 密码盐
 * @property integer $status 0正常 -1删除
 * @property string $created_at 
 * @property string $updated_at 
 */
class TestUser{
    protected $table = 'user';
    protected $primaryKey = 'id';
}