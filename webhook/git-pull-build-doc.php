<?php
$log_file = "/tmp/doc-webhook.log";

error_log("[" . date('Y-m-d H:i:s') . "]" . $raw_body . PHP_EOL, 3, $log_file);

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    die();
}

$content = file_get_contents('php://input');
$content = json_decode($content, 1);
// if ($content['password'] != '123456') {
//     die();
// }

$project = "";
if (isset($content['commits'])) {
    foreach ($content['commits'] as $commit) {
        if (preg_match("#build (\w+)#", $commit['message'], $matches)) {
            //var_dump($matches);
            $project = $matches[1];
            break;
        }
    }
}

$cmd = "sudo git pull";

if (is_dir(dirname(__DIR__) . '/docs/' . $project)) {
    $cmd .= " && sudo php builder.php {$project}";
}

$descriptorspec = array(
    0 => array("pipe", "r"),    // 标准输入，子进程从此管道中读取数据
    1 => array("pipe", "w"),    // 标准输出，子进程向此管道中写入数据
    2 => array("pipe", "w")     // 标准错误
);

$cwd = dirname(__DIR__);

$process = proc_open($cmd, $descriptorspec, $pipes, $cwd);


if (is_resource($process)) {
    $success_msg = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $error_msg = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    $return_value = proc_close($process);

    if ($return_value === 0) {
        error_log("[" . date('Y-m-d H:i:s') . "] {$cmd} " . " stdout:" . $success_msg . PHP_EOL, 3, $log_file);
    } else {
        error_log("[" . date('Y-m-d H:i:s') . "] {$cmd} " . " stderr:[" . $return_value . '] ' . $error_msg . PHP_EOL, 3, $log_file);
    }
    // return [
    // 'return_value' => $return_value,
    // 'success_msg' => $success_msg,
    // 'error_msg' => $error_msg
    // ];
}
