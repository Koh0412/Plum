<?php

namespace Plum\Commands;

abstract class BaseCommandProvider {
  protected $commands;

  /**
   * return command class instances
   *
   * @return array
   */
  protected abstract function commands(): array;

  /**
   * Return the argument classes as an instances
   *
   * @param mixed $classes
   * @return array
   */
  protected static function instanceMap($classes): array
  {
    return array_map(function($class) {
      return new $class();
    }, $classes);
  }
}
