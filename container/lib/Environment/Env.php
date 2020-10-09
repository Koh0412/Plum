<?php

namespace Plum\Environment;

use Dotenv\Dotenv;
use Exception;

class Env {
  private static $dotenv;
  private static $base_path;

  public static function setPath($path)
  {
    Env::$base_path = $path;
  }

  public static function get($key){
      if((self::$dotenv instanceof Dotenv) === false){
          if (empty(Env::$base_path)) {
            throw new Exception('dotenv path is empty. please set path');
          }
          self::$dotenv = Dotenv::createImmutable(Env::$base_path);
          self::$dotenv->load();
      }
      return array_key_exists($key, $_ENV) ? $_ENV[$key] : null;
  }
}
