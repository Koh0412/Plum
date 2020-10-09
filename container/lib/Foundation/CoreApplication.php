<?php

namespace Plum\Foundation;

use Plum\Foundation\Util\Reflect;

class CoreApplication {

  protected $base_path;

  public function __construct() {}

  /**
   * set base path that is used for read files
   *
   * @param string $path
   * @return void
   */
  public function setBasePath(string $path)
  {
    if (is_null($this->base_path)) {
      $this->base_path = $path;
    }
  }

  /**
   * handling request.
   *
   * @return void
   */
  public function run(): void
  {
    $containers = require $this->configPath().'containers.php';

    require $this->configPath().'routes.php';

    foreach ($containers as $name => $container) {
      $instance = Reflect::getInstance($container);
      $instance->run();
    }
  }

  /**
   * get config path
   *
   * @return void
   */
  protected function configPath()
  {
    return $this->base_path.'config'.DIRECTORY_SEPARATOR;
  }
}
