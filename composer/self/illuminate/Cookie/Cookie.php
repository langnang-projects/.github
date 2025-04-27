<?php

namespace Illuminate\Cookie;

class Cookie extends \Core\Illuminate
{
  function set($name, $value = null, $expire = null)
  {
    setcookie($name, $value, $expire ?: time() + 60 * 60 * 24 * 30);
  }

  function get($name = null)
  {
    if (empty($name)) return $_COOKIE;
    if (isset($_COOKIE[$name]))
      return $_COOKIE[$name];
    return;
  }
  function delete($name)
  {
    if (isset($_COOKIE[$name])) return setcookie($name, "", time() - 3600);
    return;
  }
}
