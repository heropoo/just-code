<?php

pcntl_signal(SIGCHLD, SIG_IGN); //如果父进程不关心子进程什么时候结束,子进程结束后，内核会回收。

for ($i = 0; $i < 10; $i++){
    $pid = pcntl_fork();	//创建子进程
    if($pid == -1){
        //错误处理：创建子进程失败时返回-1.
        die('could not fork');
    }else if($pid){
        echo "父进程{$i}得到pid:$pid".PHP_EOL;
        //父进程会得到子进程号，所以这里是父进程执行的逻辑
        //如果不需要阻塞进程，而又想得到子进程的退出状态，则可以注释掉pcntl_wait($status)语句，或写成：
        pcntl_wait($status,WNOHANG); //等待子进程中断，防止子进程成为僵尸进程。
    }else{
        echo '---';
        sleep($i);
        echo "子进程{$i}得到pid:{$pid}".PHP_EOL;
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        
        exit(0);
    }
}