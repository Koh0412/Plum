<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Plum\Routing\Router;

$router = router();

$router->get('/', HomeController::class, 'index');

$router->group('/users', function(Router $router) {
  $router->post('', UserController::class, 'create');
  $router->get('/{id:\d+}', UserController::class, 'show');
  $router->get('/new', UserController::class, 'new');
});

return $router;
