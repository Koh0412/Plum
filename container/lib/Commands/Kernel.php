<?php

namespace Plum\Commands;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel {
  protected $console;
  protected $type;

  public function __construct() {
    $this->console = new ConsoleApplication();
  }

  public function run(?InputInterface $input = null, ?OutputInterface $output = null): void
  {
    if (is_null($this->type)) {
      $this->setConsoleType('normal');
    }

    $this->runCommandMap($this->type);
    $this->console->run($input, $output);
  }

  /**
   * available type is `normal`, `develop`
   *
   * @param string $type
   * @return void
   */
  public function setConsoleType(string $type): void
  {
    $this->type = $type;
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

  /**
   * run add command method match type
   *
   * @param string $type
   * @return Plum\Commands\Kernel
   */
  public function runCommandMap(string $type): self
  {
    $map = [
      'normal' => function() { $this->addCommands(Commandprovider::commands()); },
      'develop' => function() { $this->addCommands(Commandprovider::internals()); }
    ];
    $execute = $map[$type];

    if (isset($execute)) {
      $execute();
    } else {
      throw new InvalidTypeException("Type: {$type} is invalid");
    }

    return $this;
  }
}
