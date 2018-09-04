<?php

$host = '127.0.0.1';//被控制的linux的ip
$port = '22';
$user = 'root';//用户名
$passwd = '123456';//密码
$connection = ssh2_connect($host, $port);// 链接远程服务器

//var_dump($connection);
if (!$connection) die("connection to $host:$port failed");

// 获取验证方式并打印
$auth_methods = ssh2_auth_none($connection, $user);
//var_dump($auth_methods);

if (in_array('password', $auth_methods)) {
	// 通过password方式登录远程服务器
	if (ssh2_auth_password($connection, $user, $passwd)) {
		echo $user . "login OK\n";
		$stream = ssh2_exec($connection, "ls -a");	//执行命令
		stream_set_blocking($stream, true);	// 为资源流设置阻塞模式
		// 获取执行ls后的内容
		if ($stream === false)
			die("ls failed");
		echo "ls: " . stream_get_contents($stream) . PHP_EOL;	//读取资源流到一个字符串
	}else{
		echo $user . "login failed\n";
	} 
}else{
	"auth use passwd not support\n";
}


