<?php
$children = []; //定义一个数组用来存储子进程的pid
$m = 10;    //fork 10次
for ($x = 0; $x < $m; $x++) {
    $pid = pcntl_fork();
    if ($pid == -1) {
        die('could not fork '.$x);
    } else if ($pid) {    //父进程执行的代码块
        $children[] = $pid;
        printf("Parent get child %d 's pid: %d\n", $x, $pid);
    } else {    //子进程执行的代码块
        $my_pid = posix_getpid();    //子进程获取自己的pid
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        echo "Child $x pid: $my_pid running...\n";
        sleep($x);        //子进程干点啥 这里是睡几秒

        echo "...Child $my_pid done\n";
        exit($x);        //子进程执行结束exit
    }
}

echo "while-------------------------\n";
while(count($children) > 0) {
    foreach($children as $key => $pid) {
        $res = pcntl_waitpid($pid, $status, WNOHANG);    //获取返回指定pid的返回状态加了第二个参数非阻塞
        if($res == -1 || $res > 0){
            echo "Parent get child $pid 's status: $status\n";
            unset($children[$key]);
        }
    }
    sleep(1);        //每一秒去轮询没有退出的子进程状态
}