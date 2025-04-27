<?php
if (!function_exists('_e')) {
  function _e($str)
  {
    echo $str;
  }
}


foreach (\glob(dirname(__DIR__) . '/illuminate/*/helpers.php') as $file) {
  $filename = array_slice(preg_split('/\\\|\//', $file), -2, 1)[0];
  if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;
  // if ($filename == 'Application') continue;
  require_once $file;
}
unset($file);
unset($filename);
