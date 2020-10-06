<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Plum\Foundation\CoreApplication;

if (empty(request()->getUri())) {
  exit;
}

$app = new CoreApplication();
$app->run();
