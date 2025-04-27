<?php


Route::prefix('webpage')->group(function () {
  Route::get('', '\Modules\WebPage\Http\Controllers\WebPageController@index');
  Route::get('/{cid}', '\Modules\WebPage\Http\Controllers\WebPageController@content');
});
