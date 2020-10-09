<?php

namespace Plum\Foundation;

use ORM;
use Plum\Environment\Env;
use Plum\Foundation\Util\Reflect;

class CoreApplication {

  protected $base_path;

  public function __construct() {
    //TODO: 一旦コメントアウト
    // ORM::configure('mysql:host={DB_HOST};dbname={DB_NAME};charset=utf8');
    // ORM::configure('username', {DB_USER});
    // ORM::configure('password', {DB_PASSWORD});
  }

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
    Env::setPath($this->base_path);

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
