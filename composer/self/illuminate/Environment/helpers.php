<?php
if (!function_exists('env')) {
  function env($name = null)
  {
    return app(__METHOD__)->get($name);
  }
}
if (!function_exists('is_mobile')) {
  function is_mobile()
  {
    return app('env')->is_mobile();
  }
}

unset($alias);
