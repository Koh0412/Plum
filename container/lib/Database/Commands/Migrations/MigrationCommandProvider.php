<?php

namespace Plum\Database\Commands\Migrations;

use Plum\Commands\BaseCommandProvider;

class MigrationCommandProvider extends BaseCommandProvider {

  protected $commands = [
    MigrateRun::class,
    MigrateInit::class,
    MigrateStatus::class,
    MigrateRollback::class
  ];

  public function commands(): array
  {
    return static::instanceMap($this->commands);
  }
}
