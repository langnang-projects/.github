<?php

namespace Illuminate\Database\Drivers;

class MySqlDriver
{
  public $alias = "mysql";
  public $con;
  function connection() {}
  function table($tbname)
  {
    return $this;
  }
  function exists() {}
}
