<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/11/4
 * Time: 23:22
 */

$data = include 'data.php';

setcsvHeader('名单.csv');

echo array2csv($data);

function setcsvHeader($filename){
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-type: application/vnd.ms-excel; charset=utf8");
    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    //设置utf-8 + bom ，处理汉字显示的乱码
    print(chr(0xEF).chr(0xBB).chr(0xBF));
}

function array2csv(array &$array){
    if (count($array) == 0) {
        return  null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
        fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
}
