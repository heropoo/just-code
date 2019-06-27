<?php

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
