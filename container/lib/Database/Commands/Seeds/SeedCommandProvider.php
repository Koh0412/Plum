<?php

namespace Plum\Database\Commands\Seeds;

use Plum\Commands\BaseCommandProvider;

class SeedCommandProvider extends BaseCommandProvider {

  protected $commands = [
    SeedCreate::class,
    SeedRun::class
  ];

  public function commands(): array
  {
    return static::instanceMap($this->commands);
  }
}
