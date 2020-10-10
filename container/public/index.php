<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Plum\Foundation\CoreApplication;

if (empty(request()->getUri())) {
  exit;
}

$home = __DIR__.DIRECTORY_SEPARATOR.UP_DIRECTORY;

$app = new CoreApplication($home);
$app->run();
