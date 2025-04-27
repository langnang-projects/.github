<?php
use Modules\Spider\Supports\phpspider\phpspider;

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

$router->group(['prefix' => 'spider'], function () use ($router) {
    $router->get('/', "SpiderController@index");
    // $router->get('/start/{slug}', "SpiderController@start");
    $router->get('/test', "SpiderController@test");
});
