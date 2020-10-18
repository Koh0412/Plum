<?php

namespace Plum\Commands;

use Plum\File\TemplateMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModel extends Command {
  use CommandTrait;

  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'make:model';
  protected $base_path = 'app/Models';

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
      ->setDescription('Creates a new model.')
      ->setHelp('This command allows you to create a model...')
      ->addArgument('model', InputArgument::REQUIRED, 'The name of the model.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    // excute this process if you run command line
    getBuffer(function() use ($input, $output) {
      $model = $input->getArgument('model');
      $filename = "{$this->base_path}/{$model}.php";

      $tMaker = new TemplateMaker('model');
      $tMaker->make(['class' => $model])->output($filename);

      $output->writeln($this->success("create model: {$model} -> successfully."));
    });
    return Command::SUCCESS;
  }
}
