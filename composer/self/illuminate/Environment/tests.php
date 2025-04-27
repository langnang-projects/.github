<?php

$illuminate = basename(__DIR__);

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('config');
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = config('module');
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  $arg = debug_backtrace()[2];
}

echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(is_mobile());
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump(gettype(null));
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  var_dump($_ENV);
}

unset($illuminate);
