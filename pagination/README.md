## php分页类

一个简单的php分页类。

### demo
![avatar](./20180612140806.png)

### usage
```php
<?php
require 'Page.php';

$count = 200;
$pageSize = 10;

$page = new \Moon\Pagination($count, $pageSize);

//分页条件 limit 10 offset 0
$offset = $page->getOffset();
$limit = $page->getLimit();
//or limit 0,10
$limitString = $page->getLimitString();

//bootstrap style pagination
echo $page->getBootstrapHtml();
```