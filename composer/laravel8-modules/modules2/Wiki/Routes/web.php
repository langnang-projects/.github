<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('wiki')->group(function () {
    Route::get('/', 'WikiController@index');
    Route::get('/meta/{midOrSlug}', 'WikiController@index');
    Route::get('/content/{cidOrSlug}', 'WikiController@view_content');
});
