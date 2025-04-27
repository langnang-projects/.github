<?php

if (!function_exists('config')) {
  function config($key, $default = null)
  {
    return app(__FUNCTION__)->get($key, $default);
  }
}
