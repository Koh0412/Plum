<?php

namespace Plum\Http;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Plum\View\FunctionHelper;
use Smarty;

class BaseController {

  protected $template_ext = '.tpl';
  private $name = 'controller';

  private const CACHE_DIR = '../var/cache/views';

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

    $this->setTemplateDirs($smarty, '../views/')
      ->setTemplateAssigns($smarty, [$param]);

    $this->registerSmartyHelper($smarty, 'function', FunctionHelper::class);

    $smarty->clearCompiledTemplate();
    $template = str_replace('.', DIRECTORY_SEPARATOR, $template);

    return $smarty->fetch($template . $this->template_ext);
  }

  /**
   * set root dir path that exists views file
   *
   * @param Smarty $smarty
   * @param string $template_dir
   * @param string $compile_dir
   * @return \Plum\Http\BaseController
   */
  private function setTemplateDirs(Smarty $smarty, string $template_dir, string $compile_dir = BaseController::CACHE_DIR): self
  {
    $smarty->template_dir = $template_dir;
    $smarty->compile_dir  = $compile_dir;
    $smarty->escape_html  = true;

    return $this;
  }

  /**
   * set assigns value for template
   *
   * @param Smarty $smarty
   * @param array $assigns
   * @return \Plum\Http\BaseController
   */
  private function setTemplateAssigns(Smarty $smarty, array $assigns): self
  {
    foreach ($assigns as $value) {
      $smarty->assign($value);
    }
    return $this;
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
