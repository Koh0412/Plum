<?php

namespace Plum\Routing\Exceptions;

use Exception;

/**
 * this exception is used when file not found
 */
class FileNotFoundException extends Exception {
  public function __construct(string $file) {
    $this->message = "file path: {$file} is not found.";
  }
}
