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

if (is_lumen()) {
  // dump(is_lumen());
  // dump(is_laravel());
  // dump(\Module::all());
  $router->get('', "HomeController@index");
  $router->group([], function () use ($router) {
    // $router->get('/', "HomeController@view_index");
    $router->get('', function (Request $request) {
      dump($request);
    });
    // $router->get('/start/{slug}', "SpiderController@start");
    $router->get('/contents', "HomeController@view_contents");
  });
}

if (is_laravel()) {
  dump(is_laravel());
  Route::prefix(\App\Support\Module::currentConfig('web.prefix'))->group(function () {
    Route::get('/', 'HomeController@view_index');
    Route::get('/contents', 'HomeController@view_contents');
  });
}