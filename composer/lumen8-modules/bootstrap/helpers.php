<?php
/**
 * 
 */
if (!function_exists('generate_ini_string')) {
  function generate_ini_string($config)
  {
    $iniString = '';
    foreach ($config as $key => $value) {
      $iniString .= sprintf("[%s]\n%s = %s\n\n", $key, $key, $value);
    }
    return $iniString;
  }
}
/**
 * 
 */
if (!function_exists("is_laravel")) {
  function is_laravel()
  {
    return class_exists(\Illuminate\Foundation\Application::class);
  }
}
/**
 * 
 */
if (!function_exists("is_lumen")) {
  function is_lumen()
  {
    return class_exists(\Laravel\Lumen\Application::class);
  }
}
