## redis cache 

一个简单的使用`predis/predis`的redis-cache组件

### 特性

- 支持自动保存时序列化，取出时自动反序列化对象和数组
- 支持给key打tag，方便批量删除

### 示例

- 缓存数据

未使用`RedisCache::cache()`快捷方法：
```php
<?php
//...

$key = 'user1';
$lifetime = 100;
$params = ['user_id'=>1, 'status'=>0];
$user = getCacheUser($key, $lifetime, $params);

/**
 * 一个常用例子
 * 从缓存中找到用户并返回，缓存不存在查数据库并缓存
 * @param string $key 缓存key
 * @param int $lifetime 缓存时间
 * @param array $params 一些数据查询条件
 */
function getCacheUser($key, $lifetime, array $params){
    $redisCache = new RedisCache();
    
    $user = $redisCache->get($key);
    if(!is_null($user)){ //缓存数据为空
        return unserialize($user); //redis中保存的是序列化后的结果
    }
    
    //下面模拟laravel的查询代码 这里根据$params查到$user对象 
    $user = User::where($params)->first();
    
    if($user){ 
        $redisCache->setex($key, $lifetime, serialize($user)); //序列化缓存
    }
    return $user;
}
```

使用`RedisCache::cache()`快捷方法：
```php
<?php
//...

$redisCache = new RedisCache();

$key = 'user1';
$lifetime = 100;
$params = ['user_id'=>1, 'status'=>0];

$user1 = $redisCache->cache($key, $lifetime, function () use($params){
    return User::where($params)->first();
});

//省去了繁琐的序列化和是否命中缓存判断以及写入缓存的代码，因为我帮你写了😂😂😂
```

- 缓存数据打tag
```php
<?php
//...

$user1 = $redisCache->cache('user1', 100, function () {
    return ['name' => 'user2', 'time' => time()];
}, false, 'test_user');

$user2 = $redisCache->cache('user2', 100, function () {
    return ['name' => 'user2', 'time' => time()];
});

$user3 = $redisCache->cache('user3', 200, function () {
    return ['name' => 'user3', 'time' => time()];
}, false, 'test_user');

// user1 和 user3 打了相同的tag `test_user`

//打包删除 user1 和 user3
$redisCache->delKeysByTag('test_user');
```


