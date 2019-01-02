<?php

$time = microtime(true);

for ($i = 0; $i < 30; $i++){
    echo $i.PHP_EOL;
    $res = file_get_contents('https://www.baidu.com');
    file_put_contents('logs/a.log',$res."\n", FILE_APPEND);
}

echo 'Used: '. (microtime(true) - $time). 's';