<?php

use App\Controllers\HomeController;
use Plum\Routing\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->run();
