<?php

use Plum\Http\Request;

if (!function_exists('request')) {

  function request() {
    $req = Request::instance();
    return $req;
  }
}
