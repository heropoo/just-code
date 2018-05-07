<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/5/7
 * Time: 12:01
 */

//todo 1.默认样式 2.锚点 3.生成目录

require 'vendor/autoload.php';

$input = isset($_GET['input']) ? $_GET['input'] : 'index';
$output = isset($_GET['output']) ? $_GET['output'] : $input;
$layout = isset($_GET['layout']) ? $_GET['layout'] : 'main';

$src = 'src/'.$input.'.md';
$dst = 'dst/'.$output.'.html';

if(!file_exists($src)){
    throw new Exception('File `'.$src.'` is not exists!');
}

if(!file_exists('src/layouts/'.$layout.'.html')){
    throw new Exception('File `src/layouts/'.$layout.'.html` is not exists!');
}

$content = \Michelf\MarkdownExtra::defaultTransform(file_get_contents($src));

$html = file_get_contents('src/layouts/'.$layout.'.html');

$html = preg_replace('#({{content}})#U', $content, $html);

file_put_contents($dst, $html);
echo $html;

