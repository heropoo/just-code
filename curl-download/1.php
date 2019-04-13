<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2019/4/13
 * Time: 22:32
 */

$url = "http://localhost:8080/meizhi.jpg";

$filename = 'm.jpg';


set_time_limit(0);


curlDownloadFile($url, [], $filename);

function curlDownloadFile($url, $data, $filename)
{
    $ch = curl_init();//初始化一个cURL会话
    curl_setopt($ch, CURLOPT_URL, $url);//抓取url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//是否显示头信息
    curl_setopt($ch, CURLOPT_POST, 1);        //模拟post请求
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);      //post提交的内容
    $data = curl_exec($ch);// 执行一个cURL会话
    $error = curl_error($ch);//返回一条最近一次cURL操作明确的文本的错误信息。
    curl_close($ch);//关闭一个cURL会话并且释放所有资源
    $file = fopen($filename, "w+");
    fputs($file, $data);//写入文件
    fclose($file);
}
