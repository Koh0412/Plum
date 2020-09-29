<?php

namespace Plum\Http;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Smarty;

class BaseController {

  private $name = 'controller';

  public function __construct() {}

  /**
   * output log
   *
   * @param mixed $message
   * @param string $file_name
   * @return void
   */
  public function logging($message, string $file_name = 'app.log'): void
  {
    $Logger = new Logger('logger');

    $Logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/' . $file_name, Logger::INFO));
    $Logger->info($message);
  }

  /**
    * create view
    *
    * @param string $template
    * @param array $param
    * @return string
    */
  public function view(string $template, array $param): string
  {
    $smarty = new Smarty();

    $smarty->template_dir = __DIR__ . '/../../views/';
    $smarty->compile_dir  = __DIR__ . '/../../lib/tmp/';
    $smarty->escape_html  = true;
    $smarty->assign([]);
    $smarty->assign($param);
    $smarty->clearCompiledTemplate();

    $template = str_replace('.', '/', $template);

    return $smarty->fetch($template . '.tpl');
  }
}
