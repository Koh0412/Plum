<?php

namespace Plum\Commands;

use Plum\File\TemplateMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommandFile extends Command {
  use CommandTrait;
  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'make:command';

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
    $this
      ->setDescription('Create a new command file.')
      ->setHelp('This command allows you to create a command file...')
      ->addArgument('filename', InputArgument::REQUIRED, 'The name of the command file.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    getBuffer(function() use ($output, $input) {
      $name = $input->getArgument('filename');
      $filename = __DIR__."/{$name}.php";

      $tMaker = new TemplateMaker('command');
      $tMaker->make(['class' => $name])->output($filename);

      $output->writeln($this->success("create command file: {$name} -> successfully."));
    });

    return Command::SUCCESS;
  }
}
