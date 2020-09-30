<?php

namespace Plum\Foundation\Exceptions;

use Exception;

class NotMatchException extends Exception {
  public function __construct(string $target) {
    $this->message = "Could not find matching {$target}";
  }
}
