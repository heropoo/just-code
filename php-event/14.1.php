<?php

$host = '0.0.0.0';
$port = 9999;
$listen_socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
socket_bind( $listen_socket, $host, $port );
socket_listen( $listen_socket );

echo PHP_EOL.PHP_EOL."Http Server ON : http://{$host}:{$port}".PHP_EOL;

// 将服务器设置为非阻塞，此处概念可能略拐弯，建议各位查阅一下手册
socket_set_nonblock( $listen_socket );
// 创建事件基础体，还记得航空母舰吗？
$event_base = new EventBase();
// 创建一个事件，还记得歼15舰载机吗？我们将“监听socket”添加到事件监听中，触发条件是read，也就是说，一旦“监听socket”上有客户端来连接，就会触发这里，我们在回调函数里来处理接受到新请求后的反应
$event = new Event( $event_base, $listen_socket, Event::READ | Event::PERSIST, function( $listen_socket ){
  // 为什么写成这样比较执拗的方式？因为，“监听socket”已经被设置成了非阻塞，这种情况下，accept是立即返回的，所以，必须通过判定accept的结果是否为true来执行后面的代码。一些实现里，包括workerman在内，可能是使用@符号来压制错误，个人不太建议这>样做
  if( ( $connect_socket = socket_accept( $listen_socket ) ) != false){
    echo "有新的客户端：".intval( $connect_socket ).PHP_EOL;
    $msg = "HTTP/1.0 200 OK\r\nContent-Length: 2\r\n\r\nHi";
    socket_write( $connect_socket, $msg, strlen( $msg ) );
    socket_close( $connect_socket );
  }
}, $listen_socket );
$event->add();
$event_base->loop();
