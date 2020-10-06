<?php

namespace Plum\Routing;

class RouteParameters {
  public $params = [];
  public function __construct(array $params)
  {
    $this->params = $params;

    foreach ($params as $name => $value) {
      $this->$name = $value;
    }
  }

  /**
   * get route uri parameter by using `$param_name`
   *
   * @param string $param_name
   * @return mixed
   */
  public function get(string $param_name)
  {
    $value = $this->params[$param_name];
    if (isset($value)) {
      return $value;
    }
  }
}
