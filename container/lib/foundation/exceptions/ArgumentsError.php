<?php

namespace Plum\Foundation\Exceptions;

use Error;

class ArgumentsError extends Error {
  public function __construct($type) {
    $this->message = <<<EOF
      Arguments Error: The argument type is incorrect. The argument type should be {$type}. <br />
      {$this->getTraceAsString()}
    EOF;
  }
}
