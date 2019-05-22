<?php

$path = __DIR__ . '/uploads';

$name = $_POST['name'];
$md5 = $_POST['md5'];

if ($_GET['type'] == 'miao') {
    if (file_exists($path . '/' . $name) && md5_file($path . '/' . $name) === $md5) {
        // 文件已存在，妙传
        echoJson(200, 'ok', [
            'url' => 'uploads/' . $name,
        ]);
    }
} else if ($_GET['type'] == 'shard') {
    $file = $_FILES['file'];

    $total = $_POST['total'];
    $index = $_POST['index'];
    $size = $_POST['size'];

    $dst_file = $path . '/' . $name . '-' . $total . ':' . $index;
    if ($file["error"] > 0) {
        echoJson(400, $file["error"]);
    } else {
        $res = move_uploaded_file($file['tmp_name'], $dst_file);
        if ($res) {
            file_put_contents($dst_file . '.info', $size);
            echoJson(200, 'shard ok');
        } else {
            echoJson(400, 'shard move_uploaded_file error');
        }
    }
} else if ($_GET['type'] == 'merge') {
    $size = $_POST['size'];
    $total = $_POST['total'];
    $msg = '';
    if (mergeFile($path . '/' . $name, $total, $msg)) {
        echoJson(200, 'ok', [
            'url' => 'uploads/' . $name,
        ]);
    } else {
        echoJson(400, $msg);
    }
}

function mergeFile($name, $total, &$msg)
{
    for ($i = 0; $i < $total; $i++) {
        if (!file_exists($name . '-' . $total . ':' . $i . '.info') || !file_exists($name . '-' . $total . ':' . $i)) {
            $msg = "shard error $i";
            return false;
        } else if (filesize($name . '-' . $total . ':' . $i) != file_get_contents($name . '-' . $total . ':' . $i . '.info')) {
            $msg = "shard size error $i";
            return false;
        }
    }

    @unlink($name);
    if (file_exists($name . '.lock')) {
        $msg = 'on lock';
        return false;
    }
    touch($name . '.lock');
    $file = fopen($name, 'a+');
    for ($i = 0; $i < $total; $i++) {
        $shardFile = fopen($name . '-' . $total . ':' . $i, 'r');
        $shardData = fread($shardFile, filesize($name . '-' . $total . ':' . $i));
        fwrite($file, $shardData);
        fclose($shardFile);
        unlink($name . '-' . $total . ':' . $i);
        unlink($name . '-' . $total . ':' . $i . '.info');
    }
    fclose($file);
    unlink($name . '.lock');

    return true;
}

function echoJson($code, $msg = '', $data = [])
{
    header('Content-type: application/json');
    //sleep(mt_rand(1,10));
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => (object)$data
    ]);
    exit();
}