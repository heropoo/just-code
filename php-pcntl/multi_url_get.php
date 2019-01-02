<?php
$time = microtime(true);

pcntl_signal(SIGCHLD, SIG_IGN); //如果父进程不关心子进程什么时候结束,子进程结束后，内核会回收。

for ($i = 0; $i < 30; $i++){
    $pid = pcntl_fork();	//创建子进程
    if($pid == -1){
        //错误处理：创建子进程失败时返回-1.
        die('could not fork');
    }else if($pid){
        echo "父进程{$i}得到pid:$pid".PHP_EOL;
        pcntl_wait($status,WNOHANG); //等待子进程中断，防止子进程成为僵尸进程。
    }else{
        echo "子进程{$i}得到pid:{$pid}".PHP_EOL;
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        $res = file_get_contents('https://www.baidu.com');
        file_put_contents('logs/a.log',$res."\n", FILE_APPEND);
        exit(0);
    }
}

echo 'Used: '. (microtime(true) - $time). 's';