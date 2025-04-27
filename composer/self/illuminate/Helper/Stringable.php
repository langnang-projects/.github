<?php

namespace Illuminate\Helper;

class Stringable
{
  public $value;

  function __construct($value)
  {
    $this->value = $value;
  }
}
