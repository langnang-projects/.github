<?php

namespace Illuminate\Install;

class Install extends \Core\Illuminate
{

  public $steps = [];
  public function addStep(InstallStep $step)
  {
    array_push($this->steps, $step);
  }
}
