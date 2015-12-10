<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use PowerTools\Console\Proxy;
use PowerTools\Console\Generate;
use PowerTools\Console\ClassmapCommand;
use PowerTools\Console\TinkerCommand;
use Symfony\Component\Console\Application;

$application = new Application('Power Tools', '0.1');
$application->add(new ClassmapCommand());
$application->add(new TinkerCommand());
$application->add(new Proxy\RegenCommand());
$application->add(new Generate\ContentItemCommand());
$application->add(new Generate\ContentCommentCommand());
$application->add(new Generate\ContentNodeCommand());
$application->run();