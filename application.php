<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use PowerTools\Command\Proxy;
use PowerTools\Command\Generate;
use PowerTools\Command\ClassmapCommand;
use PowerTools\Command\TinkerCommand;
use Symfony\Component\Console\Application;

$application = new Application('Power Tools', '0.2');
$application->add(new ClassmapCommand());
$application->add(new TinkerCommand());
$application->add(new Proxy\RegenCommand());
$application->add(new Generate\ContentItemCommand());
$application->add(new Generate\ContentCommentCommand());
$application->add(new Generate\ContentNodeCommand());
$application->add(new Generate\ActiveRecordCommand());
$application->run();