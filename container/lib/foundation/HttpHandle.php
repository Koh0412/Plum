<?php

namespace Plum\Foundation;

use Plum\Util\ServerParam;
use Throwable;

class HttpHandle {

  protected $rootName = 'home';
  protected $controller_file = '';

  protected $parse_uri = [];
  protected $get_routers = [];
  protected $post_routers = [];

  public function __construct()
  {
    $this->parse_uri = explode('/', ServerParam::getRequestURI());
  }

  /**
   * handling request. if controller file not exits, return 404
   *
   * @return void
   */
  public function run(): void
  {
    $this->controller_file = '../app/controllers/' . $this->getControllerName() . '.php';

    if (file_exists($this->controller_file)) {
      include($this->controller_file);

      if (ServerParam::getRequestMethod() == "GET") {
        $this->routerMapping($this->get_routers);
      } else {
        $this->routerMapping($this->post_routers);
      }
      exit;
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

    foreach ($this->get_routers as $route => $value) {
      if ($route === ServerParam::getRequestURINoQuery()) {
        $parse_namespace = explode('\\', $value['class']);
        $controller_name = $parse_namespace[array_key_last($parse_namespace)];
      };
    }
    return $controller_name;
  }

  /**
   * return class instance from args `$class`
   *
   * @param mixed $class
   * @return object
   */
  private function getInstance($class): object
  {
    $instance = new $class();
    return $instance;
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
          $instance = $this->getInstance($prop['class']);
          $action = $prop['action'];

          $response = $instance->$action();
        } catch (Throwable $th) {
          echo $th->getMessage(), "\n";
        }
        echo $response;
      }
    }

  }
}
