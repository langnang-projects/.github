<?php

use \Illuminate\Router\Facades\Route;

Route::prefix('wiki')->group(function () {
  Route::get('', '\Modules\Wiki\Http\Controllers\WikiController@index');
});
