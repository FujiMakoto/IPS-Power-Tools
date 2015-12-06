<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use PowerTools\Proxy;
use PowerTools\ClassmapCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ClassmapCommand());
$application->add(new Proxy\RegenCommand());
$application->run();