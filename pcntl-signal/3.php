<?php
/**
 * @see https://www.cnblogs.com/alexyuyu/articles/3853583.html
 * @see https://www.cnblogs.com/gengzj/p/3827108.html
 */

declare(ticks=1);

//安装信号处理器
pcntl_signal(SIGHUP, 'sighandler');    // 对控制进程或终端进行挂起检测
//pcntl_signal(SIGINT, 'sighandler');     // Ctrl + C
pcntl_signal(SIGTERM, 'sighandler');    // kill pid
pcntl_signal(SIGUSR1, 'sighandler');    // kill -s USR1 pid
pcntl_signal(SIGUSR2, 'sighandler');    // kill -s USR2 pid

echo 'Master process pid: ' . posix_getpid() . PHP_EOL;

$children = []; //定义一个数组用来存储子进程的pid 
$max = 10;

while (true) {

    while (count($children) < $max) {   //进程池
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('could not fork ');
        } else if ($pid) {  // 父进程执行的代码块
            $children[] = $pid;
            printf("Parent got child's pid: %d\n", $pid);
        } else {    //子进程执行的代码块
            $my_pid = posix_getpid();    //子进程获取自己的pid
            echo "Child [$my_pid] start\n";

            run($my_pid);

            echo "Child [$my_pid] end\n";
            exit(0);
        }
    }

    while (count($children) > 0) {
        foreach ($children as $key => $pid) {
            $res = pcntl_waitpid($pid, $status, WNOHANG);    //获取返回指定pid的返回状态加了第二个参数非阻塞
            if ($res == -1 || $res > 0) {
                echo "Parent get child $pid 's status: $status\n";
                unset($children[$key]);
            }
        }
        echo "Current children count is ".count($children).PHP_EOL;
        sleep(1);        //每一秒去轮询没有退出的子进程状态
    }

    echo "\n\n\n\n\n\n\n\nMaster waiting for next ...";
    sleep(10);
}


function run($pid)
{
    echo "Child $pid running...\n" . PHP_EOL;
    sleep(1);
}

function sighandler($signo)
{
    switch ($signo) {
        case SIGHUP:
            echo 'got SIGHUP ' . PHP_EOL;
            file_put_contents('test.log', 1);
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