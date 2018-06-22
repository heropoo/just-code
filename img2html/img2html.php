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
$ratio = max($width, $height)*0.15;
$widthStep = $width/$ratio;
$heightStep = $height/$ratio;
ob_start();
echo '
<style type="text/css">
*{margin:0; padding:0}
.block{
	width: 1px;
	height: 1px;
	font-size: 1px;
    //line-height: 2px;
}
</style>';
for ($i = 0; $i < $width; ($i += $widthStep)) {
    for ($j = 0; $j < $height; ($j += $heightStep)) {
        $rgb = ImageColorAt($im, $i, $j);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        printf('<span class="block" style="color:rgba(%u, %u, %u, %.1f);">▇</span>', $r, $g, $b, $alpha);
    }
    echo "<br/>";
}
ob_flush();