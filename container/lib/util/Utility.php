<?php

namespace Plum\Util;

class Utility {
  /**
   * return class instance from args `$class`
   *
   * @param mixed $class
   * @return object
   */
  public static function getInstance($class): object
  {
    $instance = new $class();
    return $instance;
  }
}
