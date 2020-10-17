<?php

namespace Plum\File;

use Exception;

class TemplateMaker {
  private $contents;
  private $template;

  public function __construct(string $file_name) {
    $this->contents = file_get_contents(__DIR__."/Template/{$file_name}.php.tt");
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
