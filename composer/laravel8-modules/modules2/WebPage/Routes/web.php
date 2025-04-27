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

Route::prefix('webpage')->group(function () {
    Route::get('/', 'WebPageController@index');


    Route::get('/meta/{id}', 'WebPageMetaController@show');
    Route::get('/content/{id}', 'WebPageContentController@show');
    Route::get('/link/{id}', 'WebPageLinkController@show');
});
