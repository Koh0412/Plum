<?php

use Plum\Http\Request;

if (!function_exists('request')) {

  function request() {
    $req = Request::instance();
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
