<?php

/**
 * RedisQueue use yii redis Connection
 */

use yii\redis\Connection;


class RedisQueueTrait2
{
    /** @var Connection $redis */
    public $redis;

    public function setRedis(Connection $redis)
    {
        $this->redis = $redis;
    }

    public function getQueueRedisKey($queueName, $prefix = '')
    {
        return $prefix . ":queue:" . $queueName . (YII_ENV_PROD ? ":prod" : ":test");
    }

    protected function handle(string $queueName, callable $callback, $lifeTime = 600)
    {
        $start = time();

        $redis = $this->redis;

        $key = $this->getQueueRedisKey($queueName);

        while ((time() - $start) <= $lifeTime) {
            try {
                //$content = $redis->blpop($key, 60);
                $content = $this->receive($key);
                echo date('[Y-m-d H:i:s]') . ": ".$content;
                $data = json_decode($content, 1);
                //var_dump($data, json_last_error_msg());
                if ($data) {
                    $res = call_user_func($callback, $data);
                    var_dump($res);
                } else {
                    sleep(1);
                    echo "No message sleep 1s\n";
                }
            } catch (\Exception $e) {
                echo $e->__toString();
                sleep(1);
            }
        }
    }

    /**
     * Add an element to the end of the queue
     * @param string $key
     * @param mixed $value
     * @param int $delay
     * @return mixed
     */
    public function push(string $key, $value, int $delay = 0)
    {
        $redis = $this->redis;
        if ($delay === 0) {
            return $redis->rpush($key, $value);
        } else if ($delay < 0) {
            throw new \InvalidArgumentException('Param `delay` should >= 0');
        }

        $time = time() + $delay;
        $hash_key = md5(uniqid() . '_' . time() . '_' . $value);
        // Begin transaction
        $redis->multi();
        $redis->zadd($key . ':zSet', $time, $hash_key);
        $redis->hset($key . ':hList', $hash_key, $value);
        $redis->expire($key . ':hList', 7 * 86400);
        $redis->expire($key . ':zSet', 7 * 86400);
        // Commit transaction
        return $redis->exec();
    }

    public function receive($key)
    {
        $redis = $this->redis;
        $res = $redis->lpop($key);
        if(!is_null($res)){
            return $res;
        }

        //if ($this->getLock($key . ':lock', 1)) {
        $keys = $redis->zrangebyscore($key . ':zSet', 0, time());
        if (!empty($keys)) {
            $messages = call_user_func_array([$redis, 'hmget'], array_merge([$key . ':hList'], $keys));
            // Begin transaction
            $redis->multi();
            foreach ($messages as $i => $message) {
                $redis->rpush($key, $message);
                $hash_key = $keys[$i];
                $redis->hdel($key . ':hList', $hash_key);
                $redis->zrem($key . ':zSet', $hash_key);
            }
            // Commit
            $redis->exec();
        }
        $this->releaseLock($key . ':lock');
//        }
        return $redis->lpop($key);
    }

    public function getLock($key, $lifetime = 60)
    {
        $redis = $this->redis;
        $ret = true;
        if ($redis->incr($key) !== 1) {
            $ret = false;
        }
        $ttl = $redis->ttl($key);
        if ($ttl === -1) {    //forever
            $redis->expire($key, $lifetime);
        }
        return $ret;
    }

    public function releaseLock($key)
    {
        $this->redis->del($key);
    }
}