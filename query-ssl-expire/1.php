<?php
$domain = "forever.run";
$res = getValidDate($domain);
var_dump($res);


function getValidDate($domain){
    $res = [];
    $context = stream_context_create([
        "ssl" => [
            "capture_peer_cert_chain" => true
        ]
    ]);
    $socket = stream_socket_client("ssl://$domain:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
    $context = stream_context_get_params($socket);
    // var_dump($context);
    //exit;
    foreach($context["options"]["ssl"]["peer_certificate_chain"] as $value){
        //使用openssl扩展解析证书，这里使用x509证书验证函数
        $certInfo = openssl_x509_parse($value);
        // var_dump($certInfo);
        if(strpos($certInfo["name"], $domain)){
            //echo "start: ".date("Y-m-d", $certInfo['validFrom_time_t'])."\n";
            //echo "end: ".date("Y-m-d", $certInfo['validTo_time_t'])."\n";
            $res['start'] = date("Y-m-d", $certInfo['validFrom_time_t']);
            $res['end'] = date("Y-m-d", $certInfo['validTo_time_t']);
        }
    }
    return $res;
}