<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/12/31
 * Time: 23:01
 */

$file = $_FILES['pic_file'];

$path = __DIR__ . '/uploads';

$dst_ext = strrchr($file['name'], '.');
$dst_file = $path . '/test'.$dst_ext;

if ($file["error"] > 0) {
    echoJson(400, $file["error"]);
} else {
    $res = move_uploaded_file($file['tmp_name'], $dst_file);
    echoJson(200, '', [
        'url'=>'uploads/test'.$dst_ext
    ]);
}


function echoJson($ret, $msg = '', $data = [])
{
    header('Content-type: application/json');
    echo json_encode([
        'ret' => $ret,
        'msg' => $msg,
        'data' => $data
    ]);
    exit();
}