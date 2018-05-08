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

$content = file_get_contents($src);

if(!empty($_GET['put_menu'])){  //放入目录列表
    $dh = opendir('src');
    $menu_src = '';
    while (($file = readdir($dh)) !== false) {
        if(strpos($file, '_menu_') === 0){
            $menu_src .= file_get_contents('src/'.$file);
        }
    }
    closedir($dh);
    $content = str_replace('<!-- menu -->', $menu_src, $content);
}

$parser = new \cebe\markdown\GithubMarkdown();
$parser->html5 = true;
$content = $parser->parse($content);

$html = file_get_contents('src/layouts/'.$layout.'.html');

$html = preg_replace('#({{content}})#U', $content, $html);

if(!empty($_GET['menu'])){  //读取目录
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $menu = '';
    $title = $dom->getElementsByTagName('h2')[0]->textContent;
    $menu .= $title.PHP_EOL;

    foreach($dom->getElementsByTagName('h3') as $h3){
        $menu .= '    * ['.$h3->textContent.']('.$input.'.html#'.urlencode($h3->textContent).')'.PHP_EOL;
        $h3->setAttribute('id', urlencode($h3->textContent));
    }
    $dom->saveHTMLFile($dst);
    file_put_contents('src/_menu_'.$input.'.md', $menu);
    echo file_get_contents($dst);
}else{
    file_put_contents($dst, $html);
    echo $html;
}