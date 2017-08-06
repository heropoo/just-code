<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/3
 * Time: 16:13
 */

namespace Moon\Routing;


use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    public function matchRequest(Request $request){

    }

}