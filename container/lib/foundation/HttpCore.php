<?php

namespace Plum\Foundation;

class HttpCore {

  protected $router_file_paths = [];

  public function __construct()
  {
    $this->router_file_paths = glob('../app/routes/*.php');
  }

  /**
   * handling request.
   *
   * @return void
   */
  public function run(): void
  {
    foreach ($this->router_file_paths as $file_path) {
      include($file_path);
    }
  }
}
