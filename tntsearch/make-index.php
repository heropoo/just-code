<?php
require_once __DIR__.'/vendor/autoload.php';

use TeamTNT\TNTSearch\TNTSearch;

$tnt = new TNTSearch;

$config = require __DIR__.'/config.php';

$tnt->loadConfig($config);

$indexer = $tnt->createIndex('name.index');
$indexer->query('SELECT id, content FROM article;');
//$indexer->setLanguage('german');
$indexer->run();