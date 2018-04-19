<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/4/16
 * Time: 13:52
 */

//require_once 'Pdf2png.php';

//try{
//   $pdf_file = './test.pdf';
//   $img_file = './test.png';
//   $obj = new Pdf2png($pdf_file, $img_file);
//}catch (Pdf2pngException $e){
//    echo $e->getMessage();
//}

function pdf2png($pdf, $path, $page = -1)
{
    if (!extension_loaded('imagick')) {
        return false;
    }
    if (!file_exists($pdf)) {
        return false;
    }
    $im = new Imagick();
    $im->setResolution(120, 120);
    $im->setCompressionQuality(100);
    if ($page == -1)
        $im->readImage($pdf);
    else
        $im->readImage($pdf . "[" . $page . "]");
    foreach ($im as $Key => $Var) {
        $Var->setImageFormat('png');
        $filename = $path . "/" . md5($Key . time()) . '.png';
        if ($Var->writeImage($filename) == true) {
            $Return[] = $filename;
        }
    }
    return $Return;
}

function pdf2JPEG($pdf, $path, $page = -1)
{
    if (!extension_loaded('imagick')) {
        return false;
    }
    if (!file_exists($pdf)) {
        return false;
    }
    $im = new Imagick();
    $im->setResolution(120, 120);
    $im->setCompressionQuality(100);
    if ($page == -1)
        $im->readImage($pdf);
    else
        $im->readImage($pdf . "[" . $page . "]");
    foreach ($im as $Key => $Var) {
        $Var->setImageFormat('jpeg');
        $filename = $path . "/" . md5($Key . time()) . '.jpeg';
        if ($Var->writeImage($filename) == true) {
            $Return[] = $filename;
        }
    }
    return $Return;
}

$res = pdf2png(realpath('./test.pdf'), __DIR__, 1);
var_dump($res);