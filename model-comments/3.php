<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/11/8
 * Time: 18:47
 */

require_once 'src/TestUser.php';

$ref =  new \ReflectionClass(\Models\TestUser::class);

//var_dump($ref);

$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

$res = $pdo->query('desc user')->fetchAll(PDO::FETCH_ASSOC);
//var_dump($res);

$string = '';

foreach($res as $item){
    $field = $item['Field'];

    $sub_type_tmp = explode(' ', str_replace('(', ' ',$item['Type']));
    switch ($sub_type_tmp[0]) {
        case 'boolean':
        case 'bool':
            $realType = 'boolean';
            break;
        case 'varchar':
        case 'char':
            $realType = 'string';
            break;
        case 'int':
        case 'integer':
        case 'tinyint':
        case 'bigint':
        case 'smallint':
        case 'timestamp':
            $realType = 'integer';
            break;
        case 'real':
        case 'double':
        case 'float':
            $realType = 'float';
            break;
        case 'date':
        case 'datetime':
            $realType = 'string';
            break;
        default:
            $realType = 'mixed';
            break;
    }
    $string .= " * @property {$realType} \${$field}\n";
}

$string = '/**
 * Class '.$ref->getName()."\n".$string.' */';

//$string;

$content = file_get_contents($ref->getFileName());

//var_dump($content);





