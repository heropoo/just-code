<?php
require_once __DIR__.'/vendor/autoload.php';

use TeamTNT\TNTSearch\TNTSearch;

$tnt = new TNTSearch;

$config = require __DIR__.'/config.php';

$tnt->loadConfig($config);
$tnt->selectIndex("name.index");

$res = $tnt->search("周华健", 12);

print_r($res);