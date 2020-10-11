<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router = router();

$router->get('/', HomeController::class, 'index');
$router->group('/users', [
  '' => ['method' => 'POST', 'controller' => UserController::class, 'action' => 'create'],
  '/{id:\d+}' => ['method' => 'GET', 'controller' => UserController::class, 'action' => 'show'],
  '/new' => ['method' => 'GET', 'controller' => UserController::class, 'action' => 'new'],
]);

return $router;
