<?php

namespace Plum\Foundation;

use Exception;

class NotMatchException extends Exception {
  public function __construct(string $target) {
    $this->message = "Could not find matching {$target}";
  }
}
