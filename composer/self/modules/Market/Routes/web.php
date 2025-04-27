<?php


Route::prefix(config('market.alias'))->group(function () {
  Route::get('', '\Modules\Market\Http\Controllers\MarketController@index');
});
