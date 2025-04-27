<?php
$illuminate = basename(__DIR__);


// Route::get('', function () {});
// ?Route&7
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get('1', function () {});
  dump(app('router'));
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get('/2', function () {});
  dump(app('router'));
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  Route::get(' /2 ', function () {});
  dump(app('router'));
}
echo "<a href='?$illuminate&" . (__LINE__ + 1) . "' style='display: block;'>$illuminate&" . (__LINE__ + 1) . "</a>";
if (array_key_exists($illuminate, $_GET) & isset($_GET[__LINE__])) {
  dump(app('router'));
}

unset($illuminate);
