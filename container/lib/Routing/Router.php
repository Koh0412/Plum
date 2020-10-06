<?php

namespace Plum\Routing;

use Exception;
use FastRoute\RouteCollector;
use Plum\Contracts\Http\IMiddleware;

class Router implements IMiddleware {

  private $routers = [];
  private static $instance;

  private function __construct() {}

  /**
   * get self instance
   *
   * @return Plum\Routing\Router
   */
  public static function instance(): self
  {
    if (empty(self::$instance)) {
      self::$instance = new Router();
    }

    return self::$instance;
  }

  /**
   * run routing if use this method, please set route
   *
   * @return void
   */
  public function run(): void
  {
    $handlers = $this->createHandlers($this->routers);

    $info = new RouteInfo($handlers);
    // start routing
    $info->dispatch();
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
    $router = $this->createRouterObj('GET', $route, $controller, $action);
    // register with get_routers
    array_push($this->routers, $router);
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
    $router = $this->createRouterObj('POST', $route, $controller, $action);
    // register with post_routers
    array_push($this->routers, $router);
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
          throw new Exception('this HTTP Method is not available.');
          break;
      }
    }
    return $this;
  }

  /**
   * create router with properties
   *
   * @param string $route
   * @param string $controller
   * @param string|null $action
   * @return array
   */
  private function createRouterObj(string $method, string $route, string $controller, ?string $action = null): array
  {
    // TODO: エラー処理するかどうか
    if (is_null($action)) {
      $handler = 'App\Controllers\\' . $controller;
    } else {
      $handler = "$controller@$action";
    }

    $router = [
      'method' => $method,
      'route' => $route,
      'handler' => $handler
    ];
    return $router;
  }

  /**
   * create routing handler by using $routers
   *
   * @param array $routers
   * @return \Closure
   */
  private function createHandlers(array $routers): \Closure
  {
    return function(RouteCollector $r) use ($routers) {
      foreach ($routers as $value) {
        switch ($value['method']) {
          case 'GET':
            $r->get($value['route'], $value['handler']);
            break;
          case 'POST':
            $r->post($value['route'], $value['handler']);
            break;
          default:
            throw new Exception('this HTTP Method is not available.');
            break;
        }
      }
    };
  }
}
