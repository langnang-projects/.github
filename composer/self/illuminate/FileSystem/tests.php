<?php
$illuminate = basename(__DIR__);


echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $file = File::of(__FILE__);
  var_dump($file);
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $path = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "_jekyll" . DIRECTORY_SEPARATOR . 'index.md';
  var_dump($path);
  $file = File::of($path);
  var_dump($file);
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $path = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "_jekyll" . DIRECTORY_SEPARATOR . 'index.md';
  var_dump($path);
  $file = File::_init($path);
  var_dump($file);
  $content = $file->read();
  var_dump($content);
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $path = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "_jekyll" . DIRECTORY_SEPARATOR . 'index.md';
  var_dump($path);
  $file = File::of($path);
  var_dump($file);
  $content = $file->read();
  var_dump($content);
}


unset($illuminate);
