<?php

namespace Plum\Routing;

use Plum\Util\IMiddleware;
use Plum\Util\ServerParam;
use Plum\Util\Utility;
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
  public function run()
  {

    $this->controller_file_path = '../app/controllers/' . $this->getControllerName() . '.php';

    if (file_exists($this->controller_file_path)) {
      include($this->controller_file_path);

      if (ServerParam::getRequestMethod() == "GET") {
        $this->routerMapping($this->get_routers);
      } else {
        $this->routerMapping($this->post_routers);
      }
    } else {
      header('HTTP/1.0 404 Not Found');
      exit;
    }

  }

  public function get(string $route, $class, string $action)
  {
    $router = [
      $route => [
        'class' => $class,
        'action' => $action
        ]
    ];
    $this->get_routers = array_merge($this->get_routers, $router);
  }

  public function post(string $route, $class, string $action)
  {
    $router = [
      $route => [
        'class' => $class,
        'action' => $action
      ]
    ];
    $this->post_routers = array_merge($this->post_routers, $router);
  }

  /**
   * get controller name. can get this by using namespace last string
   *
   * @return string
   */
  private function getControllerName(): string
  {
    $controller_name = '';

    if (ServerParam::getRequestMethod() == "GET") {
      $controller_name = $this->searchControllerName($this->get_routers);
    } else {
      $controller_name = $this->searchControllerName($this->post_routers);
    }
    return $controller_name;
  }

  /**
   * router mapping
   *
   * @param array $routers
   * @return void
   */
  private function routerMapping($routers): void
  {
    $response = null;

    foreach ($routers as $route => $prop) {
      if ($route === ServerParam::getRequestURI()) {
        try {
          $instance = Utility::getInstance($prop['class']);
          $action = $prop['action'];

          $response = $instance->$action();
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
      if ($route === ServerParam::getRequestURINoQuery()) {
        $parse_namespace = explode('\\', $value['class']);
        $controller_name = $parse_namespace[array_key_last($parse_namespace)];
      };
    }
    return $controller_name;
  }
}
