<?php

namespace Plum\Util;

class ServerParam {

  protected function __construct() {}

  public static function getRequestURI(): string
  {
    /** @var string $request_uri */
    $request_uri = $_SERVER['REQUEST_URI'];
    return $request_uri;
  }

  public static function getRequestMethod(): string
  {
    /** @var string $request_method */
    $request_method = $_SERVER['REQUEST_METHOD'];
    return $request_method;
  }

  public static function getRequestURINoQuery(): string
  {
    $uri = ServerParam::getRequestURI();
    $split_query_uri = explode('?', $uri);

    return array_shift($split_query_uri);
  }

  public static function getParseURI()
  {
    $parse_uri = explode('/', ServerParam::getRequestURI());
    return $parse_uri;
  }
}
