<?php
/**
 * Created by PhpStorm.
 * User: Heropoo
 * Date: 2019/3/29
 * Time: 15:41
 */

class Queue{
    protected $items = [];

    /**
     * Add an element to the end of the queue
     * @param string $key
     * @param mixed $value
     * @return int
     */
    public function push($key, $value){
        isset($this->items[$key]) or $this->items[$key] = [];
        return array_push($this->items[$key], $value);
    }

    /**
     * Take an element from the queue header
     * @param string $key
     * @return mixed
     */
    public function pop($key){
        isset($this->items[$key]) or $this->items[$key] = [];
        return array_shift($this->items[$key]);
    }

    /**
     * @param mixed $value
     * @param int $delay
     */
    public function lPush($value, $delay = 0){

    }

    public function rPush($value, $delay = 0){

    }

    public function lPop(){

    }

    public function rPop(){

    }


}