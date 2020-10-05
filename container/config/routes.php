<?php

use App\Controllers\HomeController;

$router = router();

$router->get('/', HomeController::class, 'index');
$router->post('/', HomeController::class, 'create');
