<?php

$shm_key = ftok(realpath('./1.php'), 't');

// Create a new shared memory block
echo $shm_id = shmop_open($shm_key, "a", 0644, 256);

$shm_data = shmop_read($shm_id, 0, 256);
var_dump($shm_data);