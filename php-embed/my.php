<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\HelloCommand;

$application = new Application();

// ... register commands
$application->add(new HelloCommand());

$application->run();