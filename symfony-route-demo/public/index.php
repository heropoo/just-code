<?php

/**
 * @date 2017-08-06
 */
require '../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$path_info = $request->getPathInfo();

echo $path_info;
echo '<hr><pre>';

// define route
$route = new \Symfony\Component\Routing\Route('/{something}',
    [
        '_controller' => app\controllers\IndexController::class
    ],
    [
        'something' => '([\w\s\x{4e00}-\x{9fa5}]+)?'   //match Chinese, English and spaces
    ]
);
$route->setMethods(['get', 'post']);
$routes = new \Symfony\Component\Routing\RouteCollection();
$routes->add('say', $route);

$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);

//match
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($routes, $context);
$parameters = $matcher->match($request->getPathInfo());

var_dump($parameters);

//Generate a URL
$generator = new \Symfony\Component\Routing\Generator\UrlGenerator($routes, $context);
$url = $generator->generate('say', ['something' => '大花 I love you']);

var_dump($url);

echo '<a href="' . $url . '">to see</a>';








