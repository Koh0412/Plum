<?php

namespace Plum\Http;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Plum\View\FunctionHelper;
use Smarty;

class BaseController {

  private $name = 'controller';

  protected $template_ext = '.tpl';

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

    $Logger->pushHandler(new StreamHandler('../var/log/' . $file_name, Logger::INFO));
    $Logger->info($message);
  }

  /**
    * create view
    *
    * @param string $template
    * @param array|null $param
    * @return string
    */
  public function view(string $template, ?array $param = null): string
  {
    $smarty = new Smarty();

    $smarty->template_dir = '../views/';
    $smarty->compile_dir  = '../var/cache/views';
    $smarty->escape_html  = true;

    $smarty->assign([]);
    if(is_null($param)) {
      $param = [];
    }
    $smarty->assign($param);

    $this->registerSmartyHelper($smarty, 'function', FunctionHelper::class);

    $smarty->clearCompiledTemplate();
    $template = str_replace('.', DIRECTORY_SEPARATOR, $template);

    return $smarty->fetch($template . $this->template_ext);
  }

  /**
   * register helper function from `$class` method to `$smarty`
   *
   * @param Smarty $smarty
   * @param string $class
   * @return void
   */
  private function registerSmartyHelper(Smarty $smarty, string $type, string $class): void
  {
    $class_method_names = get_class_methods($class);
    foreach ($class_method_names as $method_name) {
      $smarty->registerPlugin($type, $method_name, [$class, $method_name]);
    }
  }
}
