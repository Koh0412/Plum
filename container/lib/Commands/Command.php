#!/usr/bin/php
<?php

use Plum\Commands\Kernel;

require_once __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel();
$kernel->setConsoleType('develop');

$kernel->run(
  new Symfony\Component\Console\Input\ArgvInput,
  new Symfony\Component\Console\Output\ConsoleOutput
);
