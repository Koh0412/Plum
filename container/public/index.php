<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Plum\Util\ServerParam;
use Plum\Foundation\HttpCore;

if (empty(ServerParam::getRequestURI())) {
  exit;
}

$httpCore = new HttpCore();
$httpCore->run();
