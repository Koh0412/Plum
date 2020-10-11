<?php

namespace Plum\Foundation;

use Plum\Environment\Env;
use Plum\Foundation\Util\Reflect;
use Plum\Routing\FileNotFoundException;

class CoreApplication {

  protected $base_path;

  public function __construct(string $base_path) {
    $this->base_path = $base_path.DIRECTORY_SEPARATOR;
    Env::setPath($this->base_path);

    $this->boot();
  }

  /**
   * set base path that is used for read files
   *
   * @param string $path
   * @return void
   */
  public function setBasePath(string $path): void
  {
    if (is_null($this->base_path)) {
      $this->base_path = $path;
    }
  }

  /**
   * boot processer. this start application create
   *
   * @return void
   */
  public function boot(): void
  {
    $boots = require $this->configFile('boot');
    foreach ($boots as $boot) {
      $instance = Reflect::getInstance($boot);
      $instance->boot();
    }
  }

  /**
   * handling request.
   *
   * @return void
   */
  public function run(): void
  {
    $containers = require $this->configFile('containers');
    require $this->configFile('routes');

    foreach ($containers as $container) {
      $instance = Reflect::getInstance($container);
      $instance->run();
    }
  }

  /**
   * get config path
   *
   * @return string
   */
  protected function configFile(string $file): string
  {
    $path = $this->base_path.'config'.DIRECTORY_SEPARATOR.$file.'.php';
    if (file_exists($path)) {
      return $path;
    } else {
      throw new FileNotFoundException($path);
    }
  }
}
