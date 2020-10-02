<?php

namespace Plum\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateControllerCommand extends Command {
  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'make:controller';
  protected $base_path = 'app/controllers';

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
      ->setDescription('Creates a new controller.')
      ->setHelp('This command allows you to create a controller...')
      ->addArgument('controller', InputArgument::REQUIRED, 'The name of the controller.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $controller = $input->getArgument('controller');
    $filename = "{$this->base_path}/{$controller}.php";

    $text = <<<EOF
    <?php\n
    namespace App\Controllers;\n
    class {$controller} extends ApplicationController {
    }\n
    EOF;

    file_put_contents($filename, $text);
    readfile($filename);

    $output->writeln("<info>create controller: {$controller} -> successfully.</info>");

    return Command::SUCCESS;
  }
}
