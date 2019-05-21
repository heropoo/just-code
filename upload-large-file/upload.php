<?php

$file = $_FILES['file'];

$path = __DIR__ . '/uploads';

$name = $_POST['name'];
$total = $_POST['total'];
$index = $_POST['index'];
$size = $_POST['size'];

$dst_file = $path . '/'.$name.'-'.$total.':'.$index;

if ($file["error"] > 0) {
    echoJson(400, $file["error"]);
} else {
    $res = move_uploaded_file($file['tmp_name'], $dst_file);
    if($res){
        file_put_contents($dst_file.'.info', $size);
        if(mergeFile($path . '/'.$name, $total)){
            echoJson(200, 'ok', [
                'url'=> 'uploads/'.$name
            ]);
        }else{
            echoJson(201, 'shard ok');
        }
    }else{
        echoJson(400, 'shard move_uploaded_file error');
    }
}

function mergeFile($name, $total){
    $already = true;
    for ($i = 0; $i < $total; $i++){
        if(!file_exists($name.'-'.$total.':'.$i.'.info') || !file_exists($name.'-'.$total.':'.$i)){;
            $already = false;
            break;
        }else if(filesize($name.'-'.$total.':'.$i) != file_get_contents($name.'-'.$total.':'.$i.'.info')){
            $already = false;
            break;
        }
    }

    if($already){
        $file = fopen($name, 'a+');
        for ($i = 0; $i < $total; $i++){
            $shardFile = fopen($name.'-'.$total.':'.$i, 'r');
            $shardData = fread($shardFile, filesize($name.'-'.$total.':'.$i));
            fwrite($file, $shardData);
            fclose($shardFile);
            unlink($name.'-'.$total.':'.$i);
            unlink($name.'-'.$total.':'.$i.'.info');
        }
        fclose($file);

        return true;
    }
    return false;
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