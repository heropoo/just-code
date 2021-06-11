<?php

require __DIR__ . '/vendor/autoload.php';

defined('STDIN') or define('STDIN',  fopen('php://stdin',  'rb'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'wb'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'wb'));

use Symfony\Component\Console\Application;
use App\Command\HelloCommand;

$application = new Application();

// ... register commands
$application->add(new HelloCommand());

$application->run();
