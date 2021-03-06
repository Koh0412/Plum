<?php

namespace Plum\Database\Commands\Migrations;

use Phinx\Console\Command\AbstractCommand;
use Phinx\Console\Command\Init;
use Plum\Commands\CommandTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateInit extends Init {
  use CommandTrait;

  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'migrate:init';

  public function __construct()
  {
    // best practices recommend to call the parent constructor first and
    // then set your own properties. That wouldn't work in this case
    // because configure() needs the properties set in this constructor
    // $this->requirePassword = $requirePassword;

    parent::__construct();
  }

  protected function configure()
  {
    $this->setDescription('Initialize the application for Phinx')
      ->addOption(
        '--format',
        '-f',
        InputArgument::OPTIONAL,
        'What format should we use to initialize?',
        AbstractCommand::FORMAT_YML
      )
      ->addArgument('path', InputArgument::OPTIONAL, 'Which path should we initialize for Phinx?')
      ->setHelp(sprintf(
        '%sInitializes the application for Phinx%s',
        PHP_EOL,
        PHP_EOL
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    parent::execute($input, $output);
    return Command::SUCCESS;
  }
}
