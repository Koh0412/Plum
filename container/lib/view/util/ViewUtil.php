<?php

namespace Plum\View\Util;

class ViewUtil {
  public static function dispNotFound()
  {
    $not_found_path = '../public/404.html';
    header('HTTP/1.1 404 Not Found');

    if (file_exists($not_found_path)) {
      include($not_found_path);
    }
    exit;
  }
}
