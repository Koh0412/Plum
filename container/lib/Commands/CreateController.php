<?php

namespace Plum\Commands;

use Plum\File\TemplateMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateController extends Command {
  use CommandTrait;
  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'make:controller';
  protected $base_path = 'app/Controllers';

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
      ->setDescription('Create a new controller.')
      ->setHelp('This command allows you to create a controller...')
      ->addArgument('controller', InputArgument::REQUIRED, 'The name of the controller.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    getBuffer(function() use ($output, $input) {
      $controller = $input->getArgument('controller');
      $filename = "{$this->base_path}/{$controller}.php";

      if (file_exists($filename)) {
        $this->outputFileExistError($output, $filename);
      }

      $tMaker = new TemplateMaker('controller');
      $tMaker->make(['controller' => $controller])->output($filename);

      $output->writeln($this->success("create controller file: {$filename} -> successfully."));
    });

    return Command::SUCCESS;
  }
}
