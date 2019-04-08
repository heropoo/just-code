<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2019/4/8
 * Time: 17:35
 */

class Curl
{
    /** @var resource $ch */
    protected $ch;

    protected $base_uri = '';
    protected $url;
    protected $method;
    protected $data;
    protected $headers;

    public function __construct($base_uri = '')
    {
        $this->base_uri = $base_uri;
    }

    public function request($url, $method = "GET", $data = null, $headers = []){
        $this->url = $this->base_uri.$url;
        $this->method = strtoupper($method);
        $this->data = $data;
        $this->headers = $headers;
        $this->ch = curl_init($this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);
        if(!empty($headers)){
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }
        if(!is_null($this->data)){
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data);
        }
        $result = curl_exec($this->ch);
        curl_close($this->ch);

        return $result;
    }
}