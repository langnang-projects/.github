<?php

if (!function_exists('app')) {
  function app($name = null)
  {
    global $app;
    return $app->get($name);
  }
}
if (!function_exists('app_log')) {
  function app_log($text = null)
  {
    global $app;
    return $app->_log($text);
  }
}

if (!function_exists('app_path')) {
  function app_path($path = '')
  {
    return app()->path($path);
  }
}
if (!function_exists('base_path')) {
  function base_path($path = '')
  {
    return app()->basePath($path);
  }
}
if (!function_exists('config_path')) {
  function config_path($path = '')
  {
    return app()->configPath($path);
  }
}
if (!function_exists('database_path')) {
  function database_path($path = '')
  {
    return app()->databasePath($path);
  }
}
if (!function_exists('lang_path')) {
  function lang_path($path = '')
  {
    return app('path.lang') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
}
if (!function_exists('mix')) {
  function mix() {}
}
if (!function_exists('public_path')) {
  function public_path($path = '')
  {
    // return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
  }
}
if (!function_exists('resource_path')) {
  function resource_path($path = '')
  {
    return app()->resourcePath($path);
  }
}
if (!function_exists('storage_path')) {
  function storage_path($path = '')
  {
    return config('app.path.storage') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
}
if (!function_exists('absolute_path')) {
  function absolute_path($path = '') {}
}
if (!function_exists('relative_path')) {
  function relative_path($path = '') {}
}
