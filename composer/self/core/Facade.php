<?php

namespace Core;

class Facade
{
  public static $alias;
  function __call($name, $arguments)
  {
    var_dump(__METHOD__, $name, $arguments);
  }

  static function __callStatic($name, $arguments)
  {
    // var_dump(__METHOD__, $name);
    $class = static::class;
    // var_dump($class);
    // global $app;
    $alias = static::$alias;
    if (empty($alias)) {
      // var_dump(static::class);

      $filename = array_slice(explode("\\", $class), -1)[0];
      // var_dump($filename);
      // var_dump($filename);
      // var_dump($filename);
      // $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}_${2}', $filename));
      $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));
      // throw new \Error(get_called_class() . " not set static \$alias.");
    }
    if (app()->alias_exists($alias)) {
      // var_dump($app, $alias);
      if (!method_exists(app($alias), $name)) {
        throw new \Error("$name not exists.");
      }
      return app($alias)->{$name}(...$arguments);
    } else {
      // $class = new $class;
      // var_dump($class);
      // return $class->{$name}(...$arguments);
      // var_dump($class);
      $illuminate = array_slice(explode("\\", $class), -3, 1)[0];
      $facade = array_slice(explode("\\", $class), -1)[0];
      // var_dump($illuminate, $facade);
      $calssName = "Illuminate\\$illuminate\\$facade";
      if (!class_exists($calssName)) throw new Error("class($className) not exist.");
      $class = new $calssName;
      return $class->{$name}(...$arguments);
      // $class
    }
  }

  function __get($name)
  {
    var_dump(__METHOD__, $name);
  }

  function __set($name, $value)
  {
    var_dump(__METHOD__);
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
