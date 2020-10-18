<?php

namespace Plum\Commands;

class Commandprovider {
  public static function commands()
  {
    return [
      new CreateControllerCommand
    ];
  }

  public static function internals()
  {
    return [
      new CreateCommandFile
    ];
  }
}
