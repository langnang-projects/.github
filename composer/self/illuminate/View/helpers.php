<?php

if (!function_exists('view')) {
  function view(...$arguments)
  {
    return app(__FUNCTION__)->make(...$arguments);
  }
}
