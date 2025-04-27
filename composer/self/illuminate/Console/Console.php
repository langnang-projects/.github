<?php

namespace Illuminate\Console;

class Console extends \Core\Illuminate
{
  public $commands = [];
  function _autoload()
  {
    // foreach (\glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . "**" . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR . '*Command.php') as $file) {
    //   $className = "Illuminate" . substr($file, strlen(dirname(__DIR__)), -4);
    //   $commad = new $className;
    //   $this->addCommand($commad->getName(), $commad);
    // }
    // var_dump($this->commands);
  }

  function addCommand($name, $command)
  {
    $this->commands[$name] = $command;
  }
}
