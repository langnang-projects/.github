<?php

use App\Support\Helpers\ModuleHelper;
use App\Support\Module;
use Illuminate\Http\Request;

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

// Route::prefix('market')->group(function () {
//     Route::get('/', 'MarketController@index');
// });
Route::prefix('market')->group(function () {
    Route::get('', "MarketController@index");
    Route::prefix('npm')->group(function () {
        Route::get('', "MarketNpmController@index");
        Route::match(['get', 'post'], '/{name}', "MarketNpmController@view_slug");
        Route::match(['get', 'post'], '/{name}/{version}', "MarketNpmController@view_package");
    });
});

// Route::prefix(Module::currentConfig('admin.prefix'))->group(function () {
//     Route::prefix(Module::currentConfig('web.prefix'))->group(function () {
//         Route::get('', "MarketController@index");
//         Route::get('/{module}', "MarketController@view_admin_modules_intro");
//         Route::get('/{module}/install', "MarketController@view_admin_modules_install");
//         Route::get('/installed', "MarketController@view_admin_installed");
//     });
// });
