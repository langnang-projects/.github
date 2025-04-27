<?php

namespace Illuminate\Modular;

class Module
{
  function get($name = null)
  {
    return app('modular')->get_aliases($name);
  }
}
