<?php

require_once __DIR__.'/vendor/autoload.php';

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

$code = <<<'CODE'
<?php

function test($foo)
{
    var_dump($foo);
    //1+;
}
CODE;

//$res = token_get_all($code);
//var_dump($res);exit;

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

//var_dump($ast);exit;

$dumper = new NodeDumper;
echo $dumper->dump($ast) . "\n";
