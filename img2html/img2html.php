<?php
/**
 * Created by PhpStorm.
 * User: Eason
 * Date: 16/2/26
 * Time: 下午6:39
 */
// filename
$imgFile = 'img.jpg';
// pixel step
// 
// alpha channel
$alpha = 1;
// rotate angle
$angle = 90;
list($width, $height, $type, $attr) = getimagesize($imgFile);
$im = imagecreatefromjpeg($imgFile);
$im = imagerotate($im, $angle, 0);
// rotate fix
$t = $width;
$width = $height;
$height = $t;
$ratio = max($width, $height)*0.2;
$widthStep = $width/$ratio;
$heightStep = $height/$ratio;
//ob_start();
$html = '
<style type="text/css">
#myImg div{margin:0; padding:0}
#myImg span{margin:0; padding:0}
#myImg .block{
	width: 1px;
	height: 2px;
	font-size: 2px;
    line-height: 15px;
}
</style><div id="myImg">';
for ($i = 0; $i < $width; ($i += $widthStep)) {
    $html .= "<div>";
    for ($j = 0; $j < $height; ($j += $heightStep)) {
        $rgb = ImageColorAt($im, $i, $j);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $html .= sprintf('<span class="block" style="color:rgba(%u, %u, %u, %.1f);">▇</span>', $r, $g, $b, $alpha);
    }
    $html .= "</div>";
}
$html .=  '</div>';
echo $html;