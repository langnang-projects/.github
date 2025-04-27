<?php

namespace Illuminate\Session;

/**
 * PHP session 变量用于存储关于用户会话（session）的信息，或者更改用户会话（session）的设置。
 * Session 变量存储单一用户的信息，并且对于应用程序中的所有页面都是可用的。
 */
class Session extends \Core\Illuminate
{
  /**
   * 
   */
  function start()
  {
    session_start();
  }
  /**
   * 
   */
  function set($name, $value = null)
  {
    $_SESSION[$name] = $value;
  }
  /**
   * 
   */
  function get($name = null)
  {
    if (empty($name)) return $_SESSION;
    if (isset($_SESSION[$name])) return $_SESSION[$name];
    return;
  }
  /**
   * 
   */
  function isset($name)
  {
    return isset($_SESSION[$name]);
  }
  /**
   * 
   */
  function unset($name)
  {
    unset($_SESSION[$name]);
  }
  /**
   * 
   */
  function destory()
  {
    session_destroy();
  }
}
