<?php

namespace Plum\Commands;

use Plum\Database\Commands\Migrations\MigrationCommandProvider;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel {

  private $console;
  /** @var BaseCommandProvider */
  private $providers = [];

  public function __construct() {
    $this->console = new ConsoleApplication();
    $this->providers = [
      new Commandprovider,
      new MigrationCommandProvider
    ];
  }

  public function run(?InputInterface $input = null, ?OutputInterface $output = null): void
  {
    foreach ($this->providers as $provider) {
      $this->addCommands($provider->commands());
    }
    $this->console->run($input, $output);
  }

  /**
   * wrapping symfont addCommands method
   *
   * @param array $commands
   * @return void
   */
  public function addCommands(array $commands): void
  {
    $this->console->addCommands($commands);
  }
}
