<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use Plum\Util\ServerParam;
use Plum\Foundation\HttpHandle;

if (empty(ServerParam::getRequestURI())) {
  exit;
}

$httpHandle = new HttpHandle();
$httpHandle->get('/', HomeController::class, 'index');

$httpHandle->run();
