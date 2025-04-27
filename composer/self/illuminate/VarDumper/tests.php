<?php

$illuminate = basename(__DIR__);

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('config');
  var_dump($arg);
  dump($arg);
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('module');
  var_dump($arg);
  dump($arg);
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = debug_backtrace()[2];
  var_dump($arg);
  dump($arg);
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  foreach ([99999, "99999", null, debug_backtrace()[2]] as $arg) {
    var_dump($arg);
    dump($arg);
  }
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(gettype(null));
}

unset($arg);
unset($illuminate);
