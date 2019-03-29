<?php
/**
 * Created by PhpStorm.
 * User: Heropoo
 * Date: 2019/3/29
 * Time: 15:41
 */

class RedisQueue{

    protected  $client;
    public function __construct(\Predis\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Add an element to the end of the queue
     * @param string $key
     * @param mixed $value
     * @return int
     */
    public function push($key, $value){
        return $this->client->rpush($key, $value);
    }

    /**
     * Take an element from the queue header
     * @param string $key
     * @return mixed
     */
    public function pop($key){
        return $this->client->lpop($key);
    }

    public function lPush($value, $delay = 0){

    }

    public function rPush($value, $delay = 0){

    }

    public function lPop(){

    }

    public function rPop(){

    }


}