# PHPUNIT

* http://www.phpunit.cn/manual/6.5/zh_cn/writing-tests-for-phpunit.html

```
vendor/bin/phpunit --bootstrap src/Email.php tests/EmailTest
vendor/bin/phpunit --bootstrap src/Email.php --testdox tests
```

利用测试之间的依赖关系
```
vendor/bin/phpunit --verbose tests/DependencyFailureTest
```

有多重依赖的测试
```
vendor/bin/phpunit --verbose tests/MultipleDependenciesTest
```

使用返回数组的数组的数据供给器
```
vendor/bin/phpunit tests/DataTest
```