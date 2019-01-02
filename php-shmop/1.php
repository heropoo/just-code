<?php

$shm_key = ftok(__FILE__, 't');

// Create a new shared memory block
echo $shm_id = shmop_open($shm_key, "c", 0644, 256);
// shmop_close($shm_id);
echo PHP_EOL;
echo $shm_size = shmop_size($shm_id);
echo PHP_EOL;
$res = $shm_bytes_written = shmop_write($shm_id, 'Hello World!', 0);
var_dump($res);

// shmop_close($shm_id);        //内存回收
// shmop_delete ($shm_id);      //清空这个内存段的内容
