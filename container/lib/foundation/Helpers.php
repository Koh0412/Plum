<?php

if (!function_exists('request')) {

  function request() {
    /** @var Plum\Http\Request */
    $req = Plum\Http\Request::instance();
    return $req;
  }
}

if (!function_exists('get_buffer')) {

  function get_buffer(callable $func_name, array $args = [null]):string {
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
