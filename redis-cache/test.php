<?php
/**
 * Date: 2019-09-29
 * Time: 17:03
 */

require_once __DIR__ . '/vendor/autoload.php';

$redisCache = new RedisCache();

$user1 = $redisCache->cache('user1', 100, function () {
    return ['name' => 'user2', 'time' => time()];
}, false, 'test_user');

$user2 = $redisCache->cache('user2', 100, function () {
    return ['name' => 'user2', 'time' => time()];
});

$user3 = $redisCache->cache('user3', 200, function () {
    return ['name' => 'user3', 'time' => time()];
}, false, 'test_user');


