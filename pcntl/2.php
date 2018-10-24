<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/10/24
 * Time: 18:32
 */

function fork_process($options)
{
    $shared_memory_monitor = shmop_open(ftok(__FILE__, chr(0)), "c", 0644, count($options['process']));
    $shared_memory_ids = (object)array();
    for ($i = 1; $i <= count($options['process']); $i++) {
        $shared_memory_ids->$i = shmop_open(ftok(__FILE__, chr($i)), "c", 0644, $options['size']);
    }
    for ($i = 1; $i <= count($options['process']); $i++) {
        $pid = pcntl_fork();
        if (!$pid) {
            if ($i == 1)
                usleep(100000);
            $shared_memory_data = $options['process'][$i - 1]();
            shmop_write($shared_memory_ids->$i, $shared_memory_data, 0);
            shmop_write($shared_memory_monitor, "1", $i - 1);
            exit($i);
        }
    }
    while (pcntl_waitpid(0, $status) != -1) {
        if (shmop_read($shared_memory_monitor, 0, count($options['process'])) == str_repeat("1", count($options['process']))) {
            $result = array();
            foreach ($shared_memory_ids as $key => $value) {
                $result[$key - 1] = shmop_read($shared_memory_ids->$key, 0, $options['size']);
                shmop_delete($shared_memory_ids->$key);
            }
            shmop_delete($shared_memory_monitor);
            $options['callback']($result);
        }
    }
}

// Create shared memory block of size 1M for each function.
$options['size'] = pow(1024, 2);

// Define 2 functions to run as its own process.
$options['process'][0] = function () {
    // Whatever you need goes here...
    // If you need the results, return its value.
    // Eg: Long running proccess 1
    sleep(1);
    return 'Hello ';
};
$options['process'][1] = function () {
    // Whatever you need goes here...
    // If you need the results, return its value.
    // Eg:
    // Eg: Long running proccess 2
    sleep(1);
    return 'World!';
};
$options['callback'] = function ($result) {
    // $results is an array of return values...
    // $result[0] for $options['process'][0] &
    // $result[1] for $options['process'][1] &
    // Eg:
    echo $result[0] . $result[1] . "\n";
};
fork_process($options);