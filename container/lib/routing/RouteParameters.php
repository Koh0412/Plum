<?php

namespace Plum\Routing;

class RouteParameters {
  public $params = [];
  public function __construct(array $params) {
    $this->params = $params;

    foreach ($params as $name => $value) {
      $this->$name = $value;
    }
  }
}
