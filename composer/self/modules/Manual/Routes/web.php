<?php

Route::prefix(config('manual.alias'))->group(function () {
  Route::get('', '\Modules\Manual\Http\Controllers\ManualController@index');

  Route::get('{alias}', '\Modules\Manual\Http\Controllers\ManualController@alias');
  Route::get('{alias}/{illu}', '\Modules\Manual\Http\Controllers\ManualController@alias');
});

// dump(app('route'));
