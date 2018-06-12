<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/6/12
 * Time: 10:26
 */

require 'Page.php';

$count = 200;

$page = new \Moon\Page($count);

$offset = $page->getOffset();
$limit = $page->getLimit();
$limitString = $page->getLimitString();
echo "where limit $limit offset $offset";
echo '<hr>';
echo $page->getHtml();

