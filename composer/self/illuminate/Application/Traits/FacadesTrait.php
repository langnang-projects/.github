<?php

namespace Illuminate\Application\Traits;

trait FacadesTrait
{
  private $facades = [];
  /**
   * set
   */
  function set_facades($name, $value = null)
  {
    if (!is_array($this->facades)) $this->facades = [];
    $this->facades[$name] = $value;
  }
  /**
   * get
   */
  function get_facades($name = null)
  {
    if (empty($this->facades)) return;
    return empty($name) ? $this->facades : $this->facades[$name];
  }
  /**
   * is
   */
  /**
   * isset
   */
  /**
   * unset
   */
  /**
   * has
   */
  /**
   * exists
   */
  function facade_exists($name)
  {
    return array_key_exists($name, $this->facades);
  }
  /**
   * to
   */
}
