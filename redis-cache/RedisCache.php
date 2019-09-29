<?php
/**
 * Date: 2019-09-26
 * Time: 17:23
 */

use Predis\Client;

/**
 * Class RedisCache
 *
 * @see \Predis\ClientInterface
 * @method int    del(array|string $keys)
 * @method string dump($key)
 * @method int    exists($key)
 * @method int    expire($key, $seconds)
 * @method int    expireat($key, $timestamp)
 * @method array  keys($pattern)
 * @method int    move($key, $db)
 * @method mixed  object($subcommand, $key)
 * @method int    persist($key)
 * @method int    pexpire($key, $milliseconds)
 * @method int    pexpireat($key, $timestamp)
 * @method int    pttl($key)
 * @method string randomkey()
 * @method mixed  rename($key, $target)
 * @method int    renamenx($key, $target)
 * @method array  scan($cursor, array $options = null)
 * @method array  sort($key, array $options = null)
 * @method int    ttl($key)
 * @method mixed  type($key)
 * @method int    append($key, $value)
 * @method int    bitcount($key, $start = null, $end = null)
 * @method int    bitop($operation, $destkey, $key)
 * @method array  bitfield($key, $subcommand, ...$subcommandArg)
 * @method int    decr($key)
 * @method int    decrby($key, $decrement)
 * @method string get($key)
 * @method int    getbit($key, $offset)
 * @method string getrange($key, $start, $end)
 * @method string getset($key, $value)
 * @method int    incr($key)
 * @method int    incrby($key, $increment)
 * @method string incrbyfloat($key, $increment)
 * @method array  mget(array $keys)
 * @method mixed  mset(array $dictionary)
 * @method int    msetnx(array $dictionary)
 * @method mixed  psetex($key, $milliseconds, $value)
 * @method mixed  set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null)
 * @method int    setbit($key, $offset, $value)
 * @method int    setex($key, $seconds, $value)
 * @method int    setnx($key, $value)
 * @method int    setrange($key, $offset, $value)
 * @method int    strlen($key)
 * @method int    hdel($key, array $fields)
 * @method int    hexists($key, $field)
 * @method string hget($key, $field)
 * @method array  hgetall($key)
 * @method int    hincrby($key, $field, $increment)
 * @method string hincrbyfloat($key, $field, $increment)
 * @method array  hkeys($key)
 * @method int    hlen($key)
 * @method array  hmget($key, array $fields)
 * @method mixed  hmset($key, array $dictionary)
 * @method array  hscan($key, $cursor, array $options = null)
 * @method int    hset($key, $field, $value)
 * @method int    hsetnx($key, $field, $value)
 * @method array  hvals($key)
 * @method int    hstrlen($key, $field)
 * @method array  blpop(array $keys, $timeout)
 * @method array  brpop(array $keys, $timeout)
 * @method array  brpoplpush($source, $destination, $timeout)
 * @method string lindex($key, $index)
 * @method int    linsert($key, $whence, $pivot, $value)
 * @method int    llen($key)
 * @method string lpop($key)
 * @method int    lpush($key, array $values)
 * @method int    lpushx($key, $value)
 * @method array  lrange($key, $start, $stop)
 * @method int    lrem($key, $count, $value)
 * @method mixed  lset($key, $index, $value)
 * @method mixed  ltrim($key, $start, $stop)
 * @method string rpop($key)
 * @method string rpoplpush($source, $destination)
 * @method int    rpush($key, array $values)
 * @method int    rpushx($key, $value)
 * @method int    sadd($key, array $members)
 * @method int    scard($key)
 * @method array  sdiff(array $keys)
 * @method int    sdiffstore($destination, array $keys)
 * @method array  sinter(array $keys)
 * @method int    sinterstore($destination, array $keys)
 * @method int    sismember($key, $member)
 * @method array  smembers($key)
 * @method int    smove($source, $destination, $member)
 * @method string spop($key, $count = null)
 * @method string srandmember($key, $count = null)
 * @method int    srem($key, $member)
 * @method array  sscan($key, $cursor, array $options = null)
 * @method array  sunion(array $keys)
 * @method int    sunionstore($destination, array $keys)
 * @method int    zadd($key, array $membersAndScoresDictionary)
 * @method int    zcard($key)
 * @method string zcount($key, $min, $max)
 * @method string zincrby($key, $increment, $member)
 * @method int    zinterstore($destination, array $keys, array $options = null)
 * @method array  zrange($key, $start, $stop, array $options = null)
 * @method array  zrangebyscore($key, $min, $max, array $options = null)
 * @method int    zrank($key, $member)
 * @method int    zrem($key, $member)
 * @method int    zremrangebyrank($key, $start, $stop)
 * @method int    zremrangebyscore($key, $min, $max)
 * @method array  zrevrange($key, $start, $stop, array $options = null)
 * @method array  zrevrangebyscore($key, $max, $min, array $options = null)
 * @method int    zrevrank($key, $member)
 * @method int    zunionstore($destination, array $keys, array $options = null)
 * @method string zscore($key, $member)
 * @method array  zscan($key, $cursor, array $options = null)
 * @method array  zrangebylex($key, $start, $stop, array $options = null)
 * @method array  zrevrangebylex($key, $start, $stop, array $options = null)
 * @method int    zremrangebylex($key, $min, $max)
 * @method int    zlexcount($key, $min, $max)
 * @method int    pfadd($key, array $elements)
 * @method mixed  pfmerge($destinationKey, array $sourceKeys)
 * @method int    pfcount(array $keys)
 * @method mixed  pubsub($subcommand, $argument)
 * @method int    publish($channel, $message)
 * @method mixed  discard()
 * @method array  exec()
 * @method mixed  multi()
 * @method mixed  unwatch()
 * @method mixed  watch($key)
 * @method mixed  eval($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed  evalsha($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed  script($subcommand, $argument = null)
 * @method mixed  auth($password)
 * @method string echo($message)
 * @method mixed  ping($message = null)
 * @method mixed  select($database)
 * @method mixed  bgrewriteaof()
 * @method mixed  bgsave()
 * @method mixed  client($subcommand, $argument = null)
 * @method mixed  config($subcommand, $argument = null)
 * @method int    dbsize()
 * @method mixed  flushall()
 * @method mixed  flushdb()
 * @method array  info($section = null)
 * @method int    lastsave()
 * @method mixed  save()
 * @method mixed  slaveof($host, $port)
 * @method mixed  slowlog($subcommand, $argument = null)
 * @method array  time()
 * @method array  command()
 * @method int    geoadd($key, $longitude, $latitude, $member)
 * @method array  geohash($key, array $members)
 * @method array  geopos($key, array $members)
 * @method string geodist($key, $member1, $member2, $unit = null)
 * @method array  georadius($key, $longitude, $latitude, $radius, $unit, array $options = null)
 * @method array  georadiusbymember($key, $member, $radius, $unit, array $options = null)
 *
 * @package App\Components
 */
class RedisCache
{
    /** @var  Client $client */
    protected $client;

    public $host;
    public $port;
    public $password;
    public $default_db;

    public function __construct($host = 'localhost', $port = 6379, $password = null, $default_db = 0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = strlen($password) > 0 ? $password : null;
        $this->default_db = intval($default_db);
    }

    /**
     * 获取一个Predis\Client实例
     * @return Client
     */
    public function getClient()
    {
        if ($this->client instanceof Client) {
            return $this->client;
        }

        $options = [
            'replication' => 'sentinel',
            'service' => 'mymaster',
            'parameters' => [
                'database' => $this->default_db,
            ],
        ];

        if (!is_null($this->password)) {
            $options['parameters']['password'] = $this->password;
        }
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => $this->host,
            'port' => $this->port,
        ], $options);
        return $this->client;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getClient(), $name], $arguments);
    }

    /**
     * 数据缓存 自动序列化 反序列化
     * @param string $key
     * @param int $lifetime
     * @param callable $getDataFunc
     * @param bool $reset
     * @param string $tag
     * @return mixed
     */
    public function cache($key, $lifetime, callable $getDataFunc, $reset = false, $tag = null)
    {
        $client = $this->getClient();
        $result = $client->get($key);
        if (!is_null($result) && $reset != true) {

            $len = strlen($result);
            if ($len >= 19 && substr($result, -13) === '_/_/<@s@>\_\_') {  //echo serialize([]);  => a:0:{} 6+13=19
                $result = substr($result, 0, $len - 13);
                return unserialize($result);
            }
            return $result;
        }

        $result = call_user_func($getDataFunc);
        if (!is_null($result) && $result !== false) {
            $serialize = false;
            if (is_array($result) || is_object($result)) {
                $serialize = true;
            }

            if ($serialize) {
                //添加尾缀 _/_/<@s@>\_\_
                $serialize_result = serialize($result) . '_/_/<@s@>\_\_';
                $client->setex($key, $lifetime, $serialize_result);
            } else {
                $client->setex($key, $lifetime, $result);
            }
            $this->saveTagKey($tag, $key, $lifetime);
        }

        return $result;
    }

    /**
     * 通过tag批量删除
     * @param string $tag
     */
    public function delKeysByTag($tag)
    {
        $client = $this->getClient();
        $tag_key = 'TagSet[' . $tag . ']';
        $keys = $client->smembers($tag_key);
        if ($keys) {
            $client->del($keys);
            $client->del($tag_key);
        }
    }

    /**
     * 给key打tag
     * @param string $tag
     * @param string $key
     * @param int $lifetime
     */
    protected function saveTagKey($tag, $key, $lifetime)
    {
        $client = $this->getClient();
        $tag_key = 'TagSet[' . $tag . ']';
        $max = $lifetime;
        $keys = $client->smembers($tag_key);
        if ($keys) {
            foreach ($keys as $k) {
                $max = max($client->ttl($k), $max);
            }
        }
        $client->sadd($tag_key, $key);
        $client->expire($tag_key, $max);
    }
}
