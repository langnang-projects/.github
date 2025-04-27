<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Blade;

// var_dump(Blade::render("123"));

$router->get('/', function () use ($router) {
    // return $router->app->version();
    return view('index');
});
$router->get('/module', function () use ($router) {
    // return $router->app->version();
    // dump(\Nwidart\Modules\Facades\Module::all());
    return view('module');
});


$router->get('welcome', "\App\Http\Controllers\WelcomeController@index");
