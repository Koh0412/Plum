<?php

namespace Plum\File;

use Exception;
use Plum\Routing\FileNotFoundException;

class TemplateMaker {
  private $contents;
  private $template;

  private const TEMPLATE_PATH = __DIR__.'/Template';

  public function __construct(string $file_name, ?string $template_path = TemplateMaker::TEMPLATE_PATH) {
    $path = $template_path."/{$file_name}.php.tt";
    $this->contents = file_get_contents($path);

    if (!$this->contents) {
      throw new FileNotFoundException($path);
    }
  }

  /**
   * make file contents that replaced parameters
   *
   * @param array $template_param
   * @return Plum\File\TemplateMaker
   */
  public function make(array $template_param): self
  {
    $keys = array_map(function($key) {
      return '$'.$key;
    }, array_keys($template_param));
    $values = array_values($template_param);

    $this->template = str_replace($keys, $values, $this->contents);
    return $this;
  }

  /**
   * output the replaced file contents to specified `$file_name`
   *
   * @param string $file_name
   * @return void
   */
  public function output(string $file_name): void
  {
    if (is_null($this->template)) {
      throw new Exception('template is not exist.');
    }
    file_put_contents($file_name, $this->template);
    readfile($file_name);
  }
}
