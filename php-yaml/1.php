<?php

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__.'/vendor/autoload.php';

$filename = __DIR__.'/1.yaml';
$content = file_get_contents($filename);

try {
    $value = Yaml::parse('foo: bar');
    var_dump($value);

//    $values = Yaml::parse($content);
//    var_dump($values);

    $values = Yaml::parseFile($filename);
    var_dump($values);
}catch (ParseException $e){
    printf('Unable to parse the YAML string: %s', $e->getMessage());
}