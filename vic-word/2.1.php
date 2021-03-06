<?php

require_once __DIR__.'/vendor/autoload.php';

use Lizhichao\Word\VicWord;

//定义词典文件路径
//define('_VIC_WORD_DICT_PATH_',__DIR__.'/vendor/lizhichao/word/Data/dict.json');
define('_VIC_WORD_DICT_PATH_',__DIR__.'/data/dict.json');

$fc = new VicWord('json');

$str = '在《你不知道的魁拔》系列中，父母都是平民，没有纹耀，所以想要成为正经人，四处打工中偶遇阿离公主，收养了蛮吉。后来和阿离、雪伦一起学习脉术，在阿离打开第四脉门时，出现了差错，蛮小满暗中相助阿离，结果阿离一下子打开了五个脉门，不过蛮小满因此失去打开第四脉门的机会。后二人有段故事小满却在知道阿离身份后始终不肯正面面对后在阿离被监国召回后目前尚未再次相逢。在一次给一个店面当保安时，遇到雪伦抢劫，未能打赢他，不过店主一招秒掉雪伦，店主本来准备杀了雪伦，小满求情，所以店主只是让雪伦的纹耀蒙尘，雪伦离开后，店主送给小满霸钢刃。在后来的兽国军队准备劫持阿离公主的战役中，阿离被树国人带走，蛮小满和蛮吉也逃到了窝窝乡。他在窝窝乡中屡屡挑战村长，但都以失败告终。而且窝窝乡的村民都不喜欢蛮小满和蛮吉（谷鸡泰和兔村长除外）。';

$arr = $fc->getAutoWord($str);

//$f = fopen('a.csv', 'a');
//foreach ($arr as $item){
//    fputcsv($f, $item);
//}
//fclose($f);

//var_dump($arr);
foreach ($arr as $item){
    echo $item[0]." ";
}
