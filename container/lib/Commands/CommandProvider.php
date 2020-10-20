<?php

namespace Plum\Commands;

class Commandprovider extends BaseCommandProvider {

  private $is_develop;

  protected $commands = [
    CreateController::class,
    CreateModel::class,
    CreateMigration::class
  ];

  public function __construct() {
    $this->is_develop = true;

    if ($this->is_develop) {
      $this->pushDevCommand();
    }
  }

  public function commands(): array
  {
    return static::instanceMap($this->commands);
  }

  /**
   * add command to commands property for develop
   *
   * @return void
   */
  private function pushDevCommand(): void
  {
    $dev_command = [
      CreateCommandFile::class
    ];
    foreach ($dev_command as $command) {
      array_push($this->commands, $command);
    }
  }
}
