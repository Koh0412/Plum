<?php

namespace Plum\Foundation;

use ORM;
use Plum\Environment\Env;
use Plum\Foundation\Util\Reflect;

class CoreApplication {

  protected $base_path;

  public function __construct() {
    //TODO: 一旦コメントアウト
    // ORM::configure('mysql:host=db;dbname=laravel-trello;charset=utf8');
    // ORM::configure('username', 'root');
    // ORM::configure('password', 'secret');
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
