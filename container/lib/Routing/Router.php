<?php

namespace Plum\Routing;

use Exception;
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
      $method = strtoupper($prop['method']);

      $route = $root . $route;
      $action = $prop['action'] ?? null;

      $method_map = array(
        'GET' => function() use ($route, $prop, $action) {
          $this->get($route, $prop['controller'], $action);
        },
        'POST' => function() use ($route, $prop, $action) {
          $this->post($route, $prop['controller'], $action);
        }
      );

      $this->httpMethodHandling($method, $method_map);
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
        $method = $value['method'];

        $method_map = array(
          'GET' => $this->callFastRouteHttpMethod('get', $r, $value),
          'POST' => $this->callFastRouteHttpMethod('post', $r, $value)
        );

        $this->httpMethodHandling($method, $method_map);
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

  /**
   * method handling.
   * Check if there is a `$map` of the `$http_method` and execute if it exists
   *
   * @param string $http_method
   * @param array $map
   * @return void
   */
  private function httpMethodHandling(string $http_method, array $map): void
  {
    $excute_method = $map[$http_method];

    if (isset($excute_method)) {
      $excute_method();
    } else {
      throw new Exception('this HTTP Method is not available.');
    }
  }
}
