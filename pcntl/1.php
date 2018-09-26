<?php
$pid = pcntl_fork();

if($pid == -1){
	die('colud not fork')；
}else if($pid){ //父进程会得到子进程号，所以这里是父进程执行的逻辑
	pcntl_wait($status);//等待子进程中断，防止子进程成为僵尸进程。
}else{	//子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
	
}

