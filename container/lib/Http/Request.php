<?php

namespace Plum\Http;

use Plum\Foundation\BaseService;

class Request extends BaseService {
  private $headers = [];

  protected function __construct()
  {
    $this->headers = getallheaders();

    // create dynamic property
    if (isset($_POST)) {
      foreach ($_POST as $key => $value) {
        $this->$key = $value;
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
    return self::callStaticInstance('request');
  }

  public function method(): string
  {
    if (is_null($this->formData()->value('_method'))) {
      return $_SERVER['REQUEST_METHOD'];
    }
    return $this->formData()->value('_method');
  }

  /**
   * get GET method parameter by using `$name`
   *
   * @param string $name
   * @param mixed|null $default
   * @return mixed
   */
  public function query(string $name, $default = null)
  {
    if (isset($_GET[$name])) {
      return htmlspecialchars($_GET[$name]);
    }
    return $default;
  }

  /**
   * get FormData class
   *
   * @return \Plum\Http\FormData
   */
  public function formData(): \Plum\Http\FormData
  {
    $formData = new FormData();
    return $formData;
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

  /**
   * get request uri with query
   *
   * @return string
   */
  public function getUri(): string
  {
    return $_SERVER['REQUEST_URI'];
  }

  /**
   * return string that join request scheme and host name
   *
   * @return string
   */
  public function schemeHost(): string
  {
    $scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
    $host = $_SERVER['HTTP_HOST'];
    return "$scheme://$host";
  }

  /**
   * get request uri without query
   *
   * @return string
   */
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
