<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Plum\Foundation\HttpCore;

if (empty(request()->getUri())) {
  exit;
}

$httpCore = new HttpCore();
$httpCore->run();
