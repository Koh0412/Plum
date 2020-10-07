<?php

namespace Plum\Foundation;

class BaseService {
  protected static $_instances = [];

  protected static function callStaticInstance(string $key)
  {
    if (empty(static::$_instances[$key])) {
      static::$_instances[$key] = new static;
    }

    return static::$_instances[$key];
  }
}
