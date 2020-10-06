<?php

namespace Plum\Routing;

use Exception;

/**
 * this exception is used when searching controller is missing
 */
class MissingSearchException extends Exception {
  public function __construct() {
    $this->message = "Failed to search the controller. Check your routing file may be empty.";
  }
}
