<?php

namespace Plum\View;

class FunctionHelper {
  public static function link_to(array $param)
  {
    return "<a href={$param['href']}>{$param['text']}</a>";
  }
}