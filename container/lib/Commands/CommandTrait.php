<?php

namespace Plum\Commands;

trait CommandTrait {

  /**
   * output text to command line with color green
   *
   * @param string $text
   * @return string
   */
  public function success(string $text): string
  {
    return "<info>{$text}</info>";
  }

  /**
   * output text to command line with error color
   *
   * @param string $text
   * @return string
   */
  public function error(string $text): string
  {
    return "<comment>{$text}</comment>";
  }

  /**
   * output text to command line with error color
   *
   * @param string $text
   * @return string
   */
  public function warning(string $text): string
  {
    return "<error>{$text}</error>";
  }

  /**
   * output text to command line with black text on a cyan background
   *
   * @param string $text
   * @return string
   */
  public function question(string $text): string
  {
    return "<question>{$text}</question>";
  }
}
