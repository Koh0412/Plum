<?php

namespace Plum\Database\Commands\Seeds;

use Phinx\Console\Command\SeedRun as PhinxSeedRun;
use Plum\Commands\CommandTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedRun extends PhinxSeedRun {
  use CommandTrait;

  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'seed:run';

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
    parent::configure();
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    parent::execute($input, $output);
    return Command::SUCCESS;
  }
}
