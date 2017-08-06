<?php
/**
 * @date 2017-08-06
 */
require '../../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$path_info = $request->getPathInfo();

echo $path_info;
echo '<hr><pre>';

// define route
$route = new \Symfony\Component\Routing\Route('/{name}',
    [
        '_controller' => app\controllers\IndexController::class
    ],
    [
        'name' => '([\w\s\x{4e00}-\x{9fa5}]+)?'   //match chinese
    ]
);
$route->setMethods(['get', 'post']);
$routes = new \Symfony\Component\Routing\RouteCollection();
$routes->add('home', $route);

$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);

//match
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($routes, $context);
$parameters = $matcher->match($request->getPathInfo());

var_dump($parameters);

//Generate a URL
$generator = new \Symfony\Component\Routing\Generator\UrlGenerator($routes, $context);
$url = $generator->generate('home', ['name'=>'莹莹 I love you']);

var_dump($url);

echo '<a href="'.$url.'" target="_blank">to see</a>';