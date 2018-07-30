<?php

$host = '127.0.0.1';
$port = 8080;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($socket, $host, $port);
socket_listen($socket, 4);

echo "Listening $host:$port\r\n";

while (true) {
	$msgsock = socket_accept($socket);
	$buff = socket_read($msgsock, 9024);
	echo $buff.PHP_EOL;

	$host = '';
	if(preg_match("/Host:\s(\w+):/", $buff, $matches)){
		$host = $matches[1];
	}

	$headers = [
		'Content-Type: text/html; charset=utf-8',
		'Server: nginx/1.12.2',	//冒充nginx
		//set cookie
		'Set-Cookie: testcookie=中文; path=/; domain='.$host.'; expires='.gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT",time()+9600), 
	];

	$response = "HTTP/1.1 200 OK\r\n".implode("\r\n", $headers)."\r\n\r\n";
	$response .= "hello world\r\n";

	echo $response.PHP_EOL;
	socket_write($msgsock, $response);
}

socket_close($socket);

