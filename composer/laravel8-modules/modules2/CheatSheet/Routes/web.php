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

Route::prefix('cheatsheet')->group(function () {
    Route::get('/', 'CheatSheetController@index');

    Route::get('/meta/{id}', 'CheatSheetMetaController@show');
    Route::get('/content/{id}', 'CheatSheetContentController@show');
    Route::get('/link/{id}', 'CheatSheetLinkController@show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/create-meta', 'CheatSheetMetaController@create');
        Route::post('/create-meta', 'CheatSheetMetaController@store');
        Route::get('/create-content', 'CheatSheetContentController@create');
        Route::post('/create-content', 'CheatSheetContentController@store');
        Route::get('/create-link', 'CheatSheetLinkController@create');
        Route::post('/create-link', 'CheatSheetLinkController@store');

        Route::get('/update-meta/{id}', 'CheatSheetMetaController@edit');
        Route::post('/update-meta/{id}', 'CheatSheetMetaController@update');
        Route::get('/update-content/{id}', 'CheatSheetContentController@edit');
        Route::post('/update-content/{id}', 'CheatSheetContentController@update');
        Route::get('/update-link/{id}', 'CheatSheetLinkController@edit');
        Route::post('/update-link/{id}', 'CheatSheetLinkController@update');

        Route::post('/delete-meta/{id}', 'CheatSheetMetaController@destroy');
        Route::post('/delete-content/{id}', 'CheatSheetContentController@destroy');
        Route::post('/delete-link/{id}', 'CheatSheetLinkController@destroy');
    });
});
