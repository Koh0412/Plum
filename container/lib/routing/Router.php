<?php

namespace Plum\Routing;

use Exception;
use Plum\Http\Util\IMiddleware;
use Plum\Foundation\Util\Reflect;

class Router implements IMiddleware {

  protected $get_routers = [];
  protected $post_routers = [];

  /**
   * run routing if use this method, please set route
   *
   * @return void
   */
  public function run(): void
  {
    if (request()->methodType() == "GET") {
      $this->routerMapping($this->get_routers);
    } else {
      $this->routerMapping($this->post_routers);
    }
  }

  /**
   * routing get method
   *
   * @param string $route
   * @param string $controller
   * @param string|null $action
   * @return \Plum\Routing\Router
   */
  public function get(string $route, string $controller, ?string $action = null): Router
  {
    $router = $this->getProcessedRouter($route, $controller, $action);
    // register with get_routers
    $this->get_routers = array_merge($this->get_routers, $router);
    return $this;
  }

  /**
   * routing post method
   *
   * @param string $route
   * @param string $controller
   * @param string $action
   * @return \Plum\Routing\Router
   *
   */
  public function post(string $route, string $controller, ?string $action = null): Router
  {
    $router = $this->getProcessedRouter($route, $controller, $action);
    // register with post_routers
    $this->post_routers = array_merge($this->post_routers, $router);
    return $this;
  }

  /**
   * router grouping
   *
   * @param string $root
   * @param array $routers
   * @return \Plum\Routing\Router
   */
  public function group(string $root, array $routers): Router
  {
    foreach ($routers as $route => $prop) {
      $method = strtoupper($prop['method']);

      $route = $root . $route;
      $action = $prop['action'] ?? null;

      switch ($method) {
        case 'GET':
          $this->get($route, $prop['controller'], $action);
          break;
        case 'POST':
          $this->post($route, $prop['controller'], $action);
          break;
        default:
          break;
      }
    }
    return $this;
  }

  /**
   * process and return router properties
   *
   * @param string $route
   * @param string $controller
   * @param string|null $action
   * @return void
   */
  private function getProcessedRouter(string $route, string $controller, ?string $action = null): array
  {
    if (is_null($action)) {
      $exploded = explode('@', $controller);

      $controller = 'App\Controllers\\' . array_shift($exploded);
      $action = end($exploded);
    }

    $router = [
      $route => [
        'controller' => $controller,
        'action' => $action
        ]
    ];
    return $router;
  }

  /**
   * router mapping
   *
   * @param array $routers
   * @return void
   */
  private function routerMapping(array $routers): void
  {
    $response = null;

    foreach ($routers as $route => $prop) {
      if ($route === request()->getUriNoQuery()) {
        try {
          $instance = Reflect::getInstance($prop['controller']);
          $action = $prop['action'];

          $method_args = Reflect::getMethodArgs($prop['controller'], $action);
          $array_instance = Reflect::getArrayInstance($method_args);

          $response = $instance->$action(...$array_instance);
        } catch (Exception $e) {
          throw $e;
        }
        echo $response;
      }
    }
  }
}
