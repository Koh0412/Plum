<?php

namespace Plum\Environment;

use Dotenv\Dotenv;
use Exception;

class Env {
  private static $dotenv;
  public static $base_path;

  /**
   * set env file's path for using dotenv
   *
   * @param string $path
   * @return void
   */
  public static function setPath(string $path): void
  {
    Env::$base_path = $path;
  }

  /**
   * get environment variable that was setting .env file,
   * if not exists variable, they will be return NULL.
   *
   * @param string $key
   * @return mixed
   */
  public static function get(string $key)
  {
      if((self::$dotenv instanceof Dotenv) === false) {
          if (Env::$base_path !== '') {
            throw new Exception('dotenv path is empty. please set path');
          }
          self::$dotenv = Dotenv::createImmutable(Env::$base_path);
          self::$dotenv->load();
      }
      return array_key_exists($key, $_ENV) ? $_ENV[$key] : null;
  }

  /**
   * get many environment variables
   *
   * @param string ...$keys
   * @return array|null
   */
  public static function getMany(...$keys): ?array
  {
    $key_arr = [];
    if (is_null($keys)) {
      return null;
    }
    foreach ($keys as $key) {
      $key_arr = array_merge($key_arr, array(Env::get($key)));
    }
    return $key_arr;
  }
}
