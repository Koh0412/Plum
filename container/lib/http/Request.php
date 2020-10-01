<?php

namespace Plum\Http;

class Request {
  private static $instance;
  private $headers = [];

  private function __construct()
  {
    $this->headers = getallheaders();

    // create dynamic property
    if (isset($_POST)) {
      foreach ($_POST as $key => $value) {
        $this->$key = $this->post($key);

        //TODO: 保留
        // if (is_array($this->$key)) {
        //   foreach ($this->$key as $childKey => $value) {
        //     $merge = "{$key}_{$childKey}";
        //     $this->$merge = $this->post($key)[$childKey];
        //   }
        // }
      }
    }
  }

  /**
   * get self instance
   *
   * @return Plum\Http\Request
   */
  public static function instance(): self
  {
    if (empty(self::$instance)) {
      self::$instance = new Request();
    }

    return self::$instance;
  }

  public function methodType(): string
  {
    if (is_null($this->post('_method'))) {
      return $_SERVER['REQUEST_METHOD'];
    }
    return $this->post('_method');
  }

  /**
   * run GET method
   *
   * @param string $name
   * @param mixed|null $default
   * @return void
   */
  public function get(string $name, $default = null)
  {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }

  /**
   * run POST method
   *
   * @param string $name
   * @param mixed|null $default
   * @return void
   */
  public function post(string $name, $default = null)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }

  /**
   * output all request header
   *
   * @param null $name
   * @return array|string
   */
  public function header($name = null)
  {
    if (empty($name)) {
      return getallheaders();
    }
    return empty($this->headers[$name]) ? '' : $this->headers[$name];
  }

  public function getUri(): string
  {
    return $_SERVER['REQUEST_URI'];
  }

  public function getUriNoQuery(): string
  {
    $split_query_uri = explode('?', $this->getUri());
    return array_shift($split_query_uri);
  }

  public function baseUrl(): string
  {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $request_uri = $this->getUri();

    if (0 === strpos($request_uri, $script_name)) {
      return $script_name;
    } else if (0 === strpos($request_uri, dirname($script_name))) {
      return rtrim(dirname($script_name));
    }

    return '';
  }
}
