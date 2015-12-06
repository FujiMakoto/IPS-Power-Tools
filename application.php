<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use PowerTools\Proxy;
use PowerTools\ClassmapCommand;
use PowerTools\TinkerCommand;
use Symfony\Component\Console\Application;

$application = new Application('Power Tools', '0.1');
$application->add(new ClassmapCommand());
$application->add(new TinkerCommand());
$application->add(new Proxy\RegenCommand());
$application->run();