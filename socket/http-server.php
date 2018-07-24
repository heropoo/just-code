<?php

$host = '127.0.0.1';
$port = 8080;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($socket, $host, $port);
socket_listen($socket, 4);

echo "Listening $host:$port\r\n";

while (true) {
	$msgsock = socket_accept($socket);
	$buff = socket_read($msgsock,9024);
	echo $buff.PHP_EOL;

	var_dump(strlen(PHP_EOL), strlen("\r\n"), PHP_EOL === "\r\n");

	$response = "HTTP/1.1 200 OK\r\n\Content-Type: text/html; charset=utf-8;\r\n\r\n";
	$response .= "hello world\r\n";
	socket_write($msgsock, $response.$buff);
}

socket_close($socket);

