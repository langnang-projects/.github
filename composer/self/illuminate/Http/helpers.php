<?php
if (!function_exists('http')) {
  function http($name = null)
  {
    return app(__METHOD__);
  }
}
