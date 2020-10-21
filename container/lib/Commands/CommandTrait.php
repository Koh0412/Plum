<?php

namespace Plum\Commands;

use Symfony\Component\Console\Output\OutputInterface;

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
  public function warning(string $text): string
  {
    return "<comment>{$text}</comment>";
  }

  /**
   * output text to command line with error color
   *
   * @param string $text
   * @return string
   */
  public function error(string $text): string
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

  /**
   *  output text to command line with cyan text
   *
   * @param string $text
   * @return string
   */
  public function info(string $text): string
  {
    return "<fg=cyan;bg=black>{$text}</>";
  }

  private function outputFileExistError(OutputInterface $output, string $filename)
  {
    $output->writeln($this->error("file: {$filename} is already exists."));
    die();
  }
}
