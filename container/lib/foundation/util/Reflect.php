<?php

namespace Plum\Foundation\Util;

use Plum\Foundation\Exceptions\ArgumentsError;
use ReflectionClass;

class Reflect {
  /**
   * return class instance from args `$class`
   *
   * @param mixed $class
   * @return object
   */
  public static function getInstance($class): object
  {
    if (method_exists($class, 'instance')) {
      $instance = $class::instance();
      return $instance;
    }

    $instance = new $class();
    return $instance;
  }

  /**
   * get the args of method
   *
   * @param string $class_name
   * @param string $taget_method_name
   * @return \ReflectionParameter[]
   */
  public static function getMethodArgs(string $class_name, string $taget_method_name)
  {
    $ref_class = new ReflectionClass($class_name);
    $method_args = $ref_class->getMethod($taget_method_name)->getParameters();
    return $method_args;
  }

  /**
   * get instances from ref param array
   *
   * @param \ReflectionParameter[] $method_args
   * @return array
   */
  public static function getArrayInstance(array $method_args): array
  {
    $array_instance = [];

    foreach ($method_args as $value) {
      if (is_object($value->getClass())) {
        $obj = Reflect::getInstance($value->getClass()->name);
        $array_instance = array_merge($array_instance, array($obj));
      } else {
        throw new ArgumentsError('object');
      }
    }
    return $array_instance;
  }
}
