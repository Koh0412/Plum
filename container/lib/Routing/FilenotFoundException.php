<?php

namespace Plum\Routing;

use Exception;

/**
 * this exception is used when file not found
 */
class FileNotFoundException extends Exception {
  public function __construct(string $file) {
    $this->message = "file path: {$file} is not found.";
  }
}
