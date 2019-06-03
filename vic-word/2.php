<?php

require_once __DIR__.'/vendor/autoload.php';

use Lizhichao\Word\VicDict;

//定义词典文件路径
define('_VIC_WORD_DICT_PATH_',__DIR__.'/data/dict.json');

$dict = new VicDict('json');

$argv = $_SERVER['argv'];
if(count($argv) < 2){
    die('请输入你要添加的词');
}

$dict->add($argv[1]);
$dict->save();

//var_dump(json_decode(file_get_contents(_VIC_WORD_DICT_PATH_), 1));
