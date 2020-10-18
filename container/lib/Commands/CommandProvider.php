<?php

namespace Plum\Commands;

class Commandprovider {
  public static function commands()
  {
    $classes = [
      CreateController::class,
      CreateModel::class,
    ];
    return Commandprovider::instanceMap($classes);
  }

  public static function internals()
  {
    $classes = [
      CreateCommandFile::class
    ];
    return Commandprovider::instanceMap($classes);
  }

  private static function instanceMap($classes)
  {
    return array_map(function($class) {
      return new $class();
    }, $classes);
  }
}
