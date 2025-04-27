<?php

namespace Illuminate\Console;

class Kernel extends \Core\Illuminate
{
  public function handle(ArgvInput $input, ConsoleOutput $output)
  {
    $output->print();
  }
}
