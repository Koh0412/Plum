<?php

namespace Plum\Routing;

use FastRoute\RouteCollector;
use Plum\Contracts\Http\IMiddleware;
use Plum\Foundation\BaseService;

class Router extends BaseService implements IMiddleware {

  private $routers = [];

  protected function __construct() {}

  /**
   * get self instance
   *
   * @return Plum\Routing\Router
   */
  public static function instance(): self
  {
    return self::callStaticInstance('router');
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
      $route = $root . $route;
      $action = $prop['action'] ?? null;

      $condition = strtoupper($prop['method']);
      $map = array(
        'GET' => function() use ($route, $prop, $action) {
          $this->get($route, $prop['controller'], $action);
        },
        'POST' => function() use ($route, $prop, $action) {
          $this->post($route, $prop['controller'], $action);
        }
      );

      $this->lookForMap($condition, $map);
    }
    return $this;
  }

  /**
   * create router with properties
   *
   * @param string $route
   * @param string $controller
   * @param string|null $action
   * @return string[]
   */
  private function createRouterObj(string $method, string $route, string $controller, ?string $action = null): array
  {
    if (is_null($action)) {
      $handler = 'App\Controllers\\' . $controller;
    } else {
      $handler = "{$controller}@{$action}";
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
        $condition = $value['method'];

        $map = array(
          'GET' => $this->callFastRouteHttpMethod('get', $r, $value),
          'POST' => $this->callFastRouteHttpMethod('post', $r, $value)
        );

        $this->lookForMap($condition, $map);
      }
    };
  }

  /**
   * run http method of the fast-route.
   * http method name use argument that is specified `$method_name`
   *
   * @param string $method_name
   * @param \FastRoute\RouteCollector $rc
   * @param mixed $value router properties
   * @return \Closure
   */
  private function callFastRouteHttpMethod(string $method_name, \FastRoute\RouteCollector $rc, $value): \Closure
  {
    return function() use ($method_name, $rc, $value) {
      $rc->$method_name($value['route'], $value['handler']);
    };
  }
}
