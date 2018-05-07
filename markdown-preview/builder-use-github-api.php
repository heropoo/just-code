<?php
/**
 * Markdown builder
 * @see https://developer.github.com/v3/markdown/
 * User: ttt
 * Date: 2018/5/7
 * Time: 10:29
 */

$url = 'https://api.github.com/markdown';

$content = file_get_contents('src/index.md');
$data = [
    'text'=>$content,
    'mode'=>'markdown', //markdown or gfm(GitHub Flavored Markdown)
    //'context'=>'github/gollum'
];
$response = curl_post($url, $data, [
//    'Content-Type'=>'text/plain'
]);

echo $response;


/**
 * @param string $url
 * @param array $data
 * @param array $headers
 * @throws CurlErrorException
 * @throws CurlHttpException
 */
function curl_post($url, $data, $headers = [])
{
    $ch = curl_init();
    //设置请求参数
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //设置其他参数
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    //调用接口, 同步等待接受响应数据
    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        $errorMsg = "Request api error. http status: {$httpCode};";
        $errorMsg .= " curl_errno: " . curl_errno($ch) . "; curl_error: " . curl_error($ch);
        curl_close($ch);        //关闭curl, 释放资源
        throw new \CurlHttpException($errorMsg, $httpCode);
    }

    if (0 !== curl_errno($ch)) {
        $errorMsg = curl_error($ch);
        curl_close($ch);        //关闭curl, 释放资源
        throw new \CurlErrorException($errorMsg, curl_errno($ch));
    }

    curl_close($ch);        //关闭curl, 释放资源

    return $response;
}

class CurlHttpException extends Exception {}

class CurlErrorException extends Exception {}
