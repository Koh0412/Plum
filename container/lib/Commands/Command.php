#!/usr/bin/php
<?php

use Plum\Commands\Commandprovider;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application();
$app->addCommands(Commandprovider::internals());

$app->run();
