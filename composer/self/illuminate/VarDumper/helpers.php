<?php

if (!function_exists('_dump')) {
  function dump(...$arguments)
  {
    foreach (debug_backtrace() as $trace) {
      if ($trace['function'] == __FUNCTION__) {
        app('var-dumper')->print($trace);
      }
    }
  }
}
