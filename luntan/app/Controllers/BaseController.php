<?php
/**
 * Date: 2019-12-20
 * Time: 16:03
 */

namespace App\Controllers;


class BaseController
{
    public function render($view, $vars = [])
    {
        ob_start();

        header('Content-Type: text/html; charset=utf-8');
        extract($vars);
        require ROOT_PATH . '/views/' . $view . '.php';
        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }

    public function json($data)
    {
        ob_start();
        header('Content-Type: application/json');
        echo json_encode($data);

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}