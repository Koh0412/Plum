<?php

if (!function_exists('request')) {

  function request() {
    /** @var Plum\Http\Request */
    $req = Plum\Http\Request::instance();
    return $req;
  }
}

if (!function_exists('getBuffer')) {

  function getBuffer(callable $func_name, array $args = [null]):string {
    ob_start();
    call_user_func_array($func_name, $args);
    return ob_get_clean();
  }
}

if (!function_exists('router')) {

  function router() {
    /** @var \Plum\Routing\Router */
    $router = \Plum\Routing\Router::instance();
    return $router;
  }
}

if (!function_exists('rootDir')) {

  /**
   * set current Dir and How many times to go up the directory.
   * this function return the resolved path
   *
   * @param mixed $dir
   * @param integer $up
   * @return string|false
   */
  function rootDir($dir, int $up) {
    $path = $dir.DIRECTORY_SEPARATOR.'';

    for ($i=0; $i < $up; $i++) {
      $path .= '../';
    }
    return realpath($path);
  }
}
