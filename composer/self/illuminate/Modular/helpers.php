<?php
if (!function_exists('module')) {
  function module($name = null)
  {
    return Module::get($name);
  }
}
