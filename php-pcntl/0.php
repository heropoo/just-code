<?php

echo "posix_getpid()=".posix_getpid().", posix_getppid()=".posix_getppid()."\n"; 
$pid = pcntl_fork();	//创建子进程

if($pid == -1){
    //错误处理：创建子进程失败时返回-1.
    die('could not fork');
}else if($pid){
    echo "pid=".$pid.", posix_getpid()=".posix_getpid().", posix_getppid()=".posix_getppid()."\n"; 
    echo '父进程得到的pid:'.$pid.PHP_EOL;
    //父进程会得到子进程号，所以这里是父进程执行的逻辑
    //如果不需要阻塞进程，而又想得到子进程的退出状态，则可以注释掉pcntl_wait($status)语句，或写成：
    pcntl_wait($status,WNOHANG); //等待子进程中断，防止子进程成为僵尸进程。
}else{
    echo "pid=".$pid.", posix_getpid()=".posix_getpid().", posix_getppid()=".posix_getppid()."\n"; 
    echo '子进程得到的pid:'.$pid.PHP_EOL;
    //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
    
    exit(0) ;
}