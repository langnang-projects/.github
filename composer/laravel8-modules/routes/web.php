<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    $return = [
        'allEnabledModules' => Cache::remember('Module::allEnabled', 24 * 3600, function () {
            $return = [];
            foreach (Module::allEnabled() as $module) {
                array_push($return, [
                    'name' => $module->getName(),
                    'lowerName' => $module->getLowerName(),
                    'slug' => config($module->getLowerName() . '.slug', $module->getLowerName()),
                    'status' => config($module->getLowerName() . '.status', 'public'),
                ]);
            }
            return $return;
        })
    ];
    return view('welcome', $return);
});

// Route::prefix('home')->group(function () {
//     Route::get('/', 'App\Http\Controllers\Controller@index');

//     Route::get('/meta/{id}', 'App\Http\Controllers\MetaController@show');
//     Route::get('/content/{id}', 'App\Http\Controllers\ContentController@show');
//     Route::get('/link/{id}', 'App\Http\Controllers\LinkController@show');


// });
// Route::middleware(['auth'])->group(function () {
//     Route::get('/create-meta', 'App\Http\Controllers\MetaController@create');
//     Route::post('/create-meta', 'App\Http\Controllers\MetaController@store');
//     Route::get('/create-content', 'App\Http\Controllers\ContentController@create');
//     Route::post('/create-content', 'App\Http\Controllers\ContentController@store');
//     Route::get('/create-link', 'App\Http\Controllers\LinkController@create');
//     Route::post('/create-link', 'App\Http\Controllers\LinkController@store');

//     Route::get('/update-meta/{id}', 'App\Http\Controllers\MetaController@edit');
//     Route::post('/update-meta/{id}', 'App\Http\Controllers\MetaController@update');
//     Route::get('/update-content/{id}', 'App\Http\Controllers\ContentController@edit');
//     Route::post('/update-content/{id}', 'App\Http\Controllers\ContentController@update');
//     Route::get('/update-link/{id}', 'App\Http\Controllers\LinkController@edit');
//     Route::post('/update-link/{id}', 'App\Http\Controllers\LinkController@update');

//     Route::post('/delete-meta/{id}', 'App\Http\Controllers\MetaController@destroy');
//     Route::post('/delete-content/{id}', 'App\Http\Controllers\ContentController@destroy');
//     Route::post('/delete-link/{id}', 'App\Http\Controllers\LinkController@destroy');
// });
// Route::match(['get', 'post'], '/login', 'App\Http\Controllers\Controller@view_login');
// Route::match(['get', 'post'], '/register', 'App\Http\Controllers\Controller@view_register');

// Auth::routes();

// Route::get('/home123', [App\Http\ControllersController::class, 'index'])->name('home');


// require_once __DIR__ . '/web.modules.php';

// use Illuminate\Support\Facades\Blade;

// var_dump(Blade::render("123"));
Auth::routes();


