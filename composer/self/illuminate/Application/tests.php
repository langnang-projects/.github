<?php

$illuminate = basename(__DIR__);

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  dump(app()->aliases);
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  dump(app()->aliases);
}
// 
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('ILLUMINATE_IGNORES[]=' . basename($dir) . PHP_EOL . "<br/>");
    unset($dir);
  }
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach (\glob(dirname(__DIR__) . '/*', GLOB_ONLYDIR) as $dir) {
    echo ('**/illuminate/' . basename($dir) . '/**' . PHP_EOL . "<br/>");
    unset($dir);
  }
}
foreach (\glob(__DIR__ . '/../*/tests.php') as $file) {
  $filename = array_slice(preg_split('/\\\|\//', $file), -2, 1)[0];
  if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;
  if ($filename == 'Application') continue;
  require_once $file;
  unset($file);
}

unset($illuminate);
