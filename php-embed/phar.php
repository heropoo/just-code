<?php
// set php.ini 'phar.readonly=Off'

unlink('./console.phar');

$phar = new Phar('console.phar', 0);
$phar->setDefaultStub('console.php');
//$phar->addFile('./console.php', 'console.php');
$phar->buildFromDirectory('.', '/composer.json|composer.lock|console.php|.php$/');
