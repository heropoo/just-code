<?php

require_once 'src/TestUser.php';
require_once 'src/FillModelPropertiesComment.php';

$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

$fill = new FillModelPropertiesComment($pdo, 'user');
$fill->fill(App\Models\TestUser::class);