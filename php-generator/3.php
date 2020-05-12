<?php

$ch1 = curl_init();
// 这个地址中的php，我故意sleep了5秒钟，然后输出一坨json
curl_setopt( $ch1, CURLOPT_URL, "http://www.selfctrler.com/index.php/test/test1" );
curl_setopt( $ch1, CURLOPT_HEADER, 0 );
$mh = curl_multi_init();
curl_multi_add_handle( $mh, $ch1 );
function gen1( $mh, $ch1 ) {
  do {
    $mrc = curl_multi_exec( $mh, $running );
    // 请求发出后，让出cpu
    $rs = yield;
    echo "外部发送数据{$rs}".PHP_EOL;
  } while( $running > 0 );
  $ret = curl_multi_getcontent( $ch1 );
  echo $ret.PHP_EOL;
  return false;
}
function gen2() {
  for ( $i = 1; $i <= 10; $i++ ) {
    echo "gen2 : {$i}".PHP_EOL;
    file_put_contents( "./yield.log", "gen2".$i, FILE_APPEND );
    $rs = yield;
    echo "外部发送数据{$rs}".PHP_EOL;
  }
}
$gen1 = gen1( $mh, $ch1 );
$gen2 = gen2();
while( true ) {
  echo $gen1->current();
  echo $gen2->current();
  $gen1->send("gen1");
  $gen2->send("gen2");
}
