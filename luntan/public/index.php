<?php
error_reporting(E_ALL & ~E_DEPRECATED);

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/vendor/autoload.php';

use Moon\Db\Connection;
use App\Container;
use App\HttpException;
use App\Exception;

//获取配置
$config = require ROOT_PATH . '/config/app.php';

//初始化db组件
$db = new Connection($config['db']);
Container::add('db', $db);


//初始化redis组件
$redis = new Redis();
$redis->connect($config['redis']['host'], $config['redis']['port']);
Container::add('redis', $redis);

//解析URL
$path = get_request_path();

//路由配置
$routes_config = require ROOT_PATH . '/config/routes.php';

//路由匹配
$action = '';
foreach ($routes_config['map'] as $rule_path => $rule_action) {
    if ($rule_path === $path) { //路由匹配
        $action = $routes_config['namespace'] . '\\' . $rule_action;
        break;
    }
}

try {
    if (empty($action)) {
        throw new HttpException('NOT FOUND', 404);
    }

    //解析到控制器
    $actionArr = explode('@', $action);
    $controllerName = $actionArr[0];
    if (!class_exists($controllerName)) {
        throw new Exception("Controller class '$controllerName' is not exists!");
    }
    $controller = new $controllerName;
    $methodName = $actionArr[1];
    if (!method_exists($controller, $methodName)) {
        throw new Exception("Controller method '$controllerName::$methodName' is not defined!");
    }

    //调用控制器 方法
    $response = call_user_func([$controller, $methodName]);
    echo $response;

} catch (HttpException $e) {
    if ($e->getCode() == 404) {
        Header("HTTP/1.1 404 Not Found");
    } else {
        throw $e;   //todo 处理其他http状态码
    }
}

//todo 处理其他异常
