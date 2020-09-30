<?php

namespace Plum\Routing\Exceptions;

use Exception;

class FileNotFoundException extends Exception {
  public function __construct(string $file) {
    $this->message = "file path: {$file} is not found.";
  }
}
