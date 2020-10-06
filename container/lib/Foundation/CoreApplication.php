<?php

namespace Plum\Foundation;

use Plum\Foundation\Util\Reflect;

class CoreApplication {

  public function __construct() {}

  /**
   * handling request.
   *
   * @return void
   */
  public function run(): void
  {
    $containers = include('../config/containers.php');

    include('../config/routes.php');

    foreach ($containers as $name => $container) {
      $instance = Reflect::getInstance($container);
      $instance->run();
    }
  }
}
