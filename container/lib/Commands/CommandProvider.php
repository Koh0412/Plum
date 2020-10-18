<?php

namespace Plum\Commands;

class Commandprovider {
  public static function commands()
  {
    return [
      new CreateControllerCommand,
      new CreateModelCommand
    ];
  }

  public static function internals()
  {
    return [
      new CreateCommandFile
    ];
  }
}
