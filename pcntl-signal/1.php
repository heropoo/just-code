<?php

/**
 * @see https://www.cnblogs.com/alexyuyu/articles/3853583.html
 * @see https://www.cnblogs.com/gengzj/p/3827108.html
 */

declare(ticks = 1);

//安装信号处理器
pcntl_signal(SIGHUP,  'sighandler');    // 对控制进程或终端进行挂起检测
pcntl_signal(SIGINT, 'sighandler');     // Ctrl + C
pcntl_signal(SIGTERM, 'sighandler');    // kill pid
pcntl_signal(SIGUSR1, 'sighandler');    // kill -s USR1 pid
pcntl_signal(SIGUSR2, 'sighandler');    // kill -s USR2 pid
pcntl_signal(SIGTSTP, 'sighandler');    // Ctrl + Z

echo 'my pid :'.posix_getpid().PHP_EOL;

while (true){
    run();
}

function run(){
    echo 'running...'.PHP_EOL;
    sleep(1);
}

function sighandler($signo)
{
    switch ($signo) {
        case SIGHUP:
            echo 'got SIGHUP ' . PHP_EOL;
            file_put_contents('test.log', 1);
            break;

        case SIGINT:
            echo 'got SIGINT ' . PHP_EOL;
            break;

        case SIGTERM:
            echo 'got SIGTERM ' . PHP_EOL;
            break;

        case SIGUSR1:
            echo 'got SIGUSR1 ' . PHP_EOL;
            break;

        case SIGUSR2:
            echo 'got SIGUSR2 ' . PHP_EOL;
            break;

        default:        // 处理所有其他信号
            echo 'got other sig :' . $signo . PHP_EOL;
    }
}