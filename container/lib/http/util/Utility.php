<?php

namespace Plum\Http\Util;

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

  public static function dispNotFound()
  {
    $not_found_path = '../public/404.html';
    header('HTTP/1.1 404 Not Found');

    if (file_exists($not_found_path)) {
      include($not_found_path);
    }
    exit;
  }
}
