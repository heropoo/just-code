<?php

require '../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$path_info = $request->getPathInfo();

echo $path_info;
echo '<hr><pre>';

/*$route = new \Moon\Routing\Route();
$route->setPath('path')
    ->setMethods(['get', 'post'])
    ->setCallback(function(){
    return 'login';
});

$collection = new \Moon\Routing\RouteCollection();

$collection->add('login', $route);
$collection->add('home', new \Moon\Routing\Route([
    'path'=>'/',
    'methods'=>'get',
    'callback'=>'IndexController::index'
]));

foreach($collection as $name=>$value){
    var_dump($name, $value);
}*/








