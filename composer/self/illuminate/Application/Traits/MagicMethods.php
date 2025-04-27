<?php

namespace Illuminate\Application\Traits;

trait MagicMethods
{


  function __get($name)
  {
    // var_dump(__METHOD__, $name);
    // return $this->{$name};
  }

  function __set($name, $value)
  {
    // var_dump([__METHOD__, $name, $value]);
    $this->{$name} = $value;
  }

  function __isset($name)
  {
    var_dump(__METHOD__);
  }

  function __unset($name)
  {
    var_dump(__METHOD__);
  }

  function __sleep()
  {
    var_dump(__METHOD__);
  }

  function __wakeup()
  {
    var_dump(__METHOD__);
  }

  function __serialize()
  {
    var_dump(__METHOD__);
  }

  function __toString()
  {
    var_dump(__METHOD__);
  }

  function __invoke()
  {
    var_dump(__METHOD__);
  }

  function __clone()
  {
    var_dump(__METHOD__);
  }

  function __debugInfo()
  {
    // var_dump(__METHOD__);
  }
}
