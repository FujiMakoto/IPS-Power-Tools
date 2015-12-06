<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use PowerTools\GreetCommand;
use PowerTools\Proxy;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new GreetCommand());
$application->add(new Proxy\RegenCommand());
$application->run();