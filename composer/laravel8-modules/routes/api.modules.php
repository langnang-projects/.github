<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API 接口代理
Route::match(['get', 'post', 'put', 'delete'], '/proxy', function (Request $request) {
    $url = $request->filled('url') ? $request->input('url') : abort(404);
    $method = $request->filled('method') ? $request->input('method') : 'get';

    $response = Http::{$method}($url);

    echo $response->body();
});
