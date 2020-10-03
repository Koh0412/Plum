<?php

namespace Plum\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
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

    get_buffer(function() use ($output, $input) {
      $progressbar = new ProgressBar($output, 10);

      $controller = $input->getArgument('controller');
      $filename = "{$this->base_path}/{$controller}.php";

      for ($i = 0; $i < 10; $i++) {
        usleep(150000);
        $progressbar->advance();
      }

      file_put_contents($filename, $this->template(['controller' => $controller]));
      readfile($filename);

      $output->writeln($progressbar->finish());
      $output->writeln("<info>create controller: {$controller} -> successfully.</info>");
    });

    return Command::SUCCESS;
  }

  private function template(array $data)
  {
    $template = <<<EOF
    <?php\n
    namespace App\Controllers;\n
    class {$data['controller']} extends ApplicationController {
    }\n
    EOF;

    return $template;
  }
}
