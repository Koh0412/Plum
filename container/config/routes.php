<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router = router();

$router->get('/', HomeController::class, 'index');
$router->get('/users/{id}', UserController::class, 'show');
$router->post('/users', UserController::class, 'create');

return $router;
