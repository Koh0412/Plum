<?php

namespace Plum\Routing;

use Plum\Foundation\Exceptions\NotMatchException;
use Plum\Http\Util\IMiddleware;
use Plum\Foundation\Util\Reflect;
use Plum\Routing\Exceptions\FileNotFoundException;
use Plum\Routing\Exceptions\MissingSearchException;

use Throwable;

class Router implements IMiddleware {

  protected $controller_file_path = '';

  protected $get_routers = [];
  protected $post_routers = [];

  /**
   * run routing if use this method, please set route
   *
   * @return void
   */
  public function run(): void
  {
    $this->controller_file_path = '../app/controllers/' . $this->getControllerName() . '.php';

    if (file_exists($this->controller_file_path)) {
      include($this->controller_file_path);

      if (request()->methodType() == "GET") {
        $this->routerMapping($this->get_routers);
      } else {
        $this->routerMapping($this->post_routers);
      }
    } else {
      throw new FileNotFoundException($this->controller_file_path);
      // ViewUtil::dispNotFound();
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
   * get controller name. can get this by using namespace last string
   *
   * @return string
   */
  private function getControllerName(): string
  {
    if (request()->methodType() == "GET") {
      $controller_name = $this->searchControllerName($this->get_routers);
    } else {
      $controller_name = $this->searchControllerName($this->post_routers);
    }
    return $controller_name;
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
      $routing_props = explode('@', $controller);

      $controller = 'App\Controllers\\' . array_shift($routing_props);
      $action = end($routing_props);
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
        } catch (Throwable $th) {
          echo $th->getMessage(), "\n";
        }
        echo $response;
      }
    }
  }

  /**
   * searching controller name from `$routers`
   *
   * @param array $routers
   * @return string
   */
  private function searchControllerName(array $routers): string
  {
    $controller_name = '';

    foreach ($routers as $route => $value) {
      if ($route === request()->getUriNoQuery()) {
        $parse_namespace = explode('\\', $value['controller']);
        $controller_name = end($parse_namespace);
      }
    }

    if ($controller_name === '') {
      if (empty($routers)) {
        throw new MissingSearchException();
      } else {
        throw new NotMatchException('route');
      }
    }

    return $controller_name;
  }
}
