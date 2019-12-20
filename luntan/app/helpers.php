<?php
/**
 * Date: 2019-12-20
 * Time: 16:51
 */

/**
 * @param string $path
 * @param array $query
 * @return string
 */
function url($path, $query = [])
{
    $base_path = dirname($_SERVER['SCRIPT_NAME']);
    $url = str_replace('//', '/', $base_path . '/' . $path);
    return empty($query) ? $url : $url . '?' . http_build_query($query);
}

function get_request_path()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = substr($uri, -(strlen($uri) - strlen(dirname($_SERVER['SCRIPT_NAME']))));
    $path = str_replace('//', '/', '/' . $path);
    return $path;
}

function get_request_method()
{
    return $_SERVER['REQUEST_METHOD'];
}