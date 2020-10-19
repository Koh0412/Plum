<?php

namespace Plum\Foundation;

use Exception;

class BaseService {
  protected static $_instances = [];
  protected const METHOD_DELIMITER = '@';

  protected static function callStaticInstance(string $key)
  {
    if (empty(static::$_instances[$key])) {
      static::$_instances[$key] = new static;
    }

    return static::$_instances[$key];
  }

  /**
   * look for a value that matches the condition and execute it if it exists
   *
   * @param string $http_method
   * @param array $map
   * @return void
   */
  protected function lookForMap(string $condition, array $map): void
  {
    $execute = $map[$condition];

    if (isset($execute)) {
      $execute();
    } else {
      throw new Exception("this condition: {$condition} is not available in this map.");
    }
  }
}
