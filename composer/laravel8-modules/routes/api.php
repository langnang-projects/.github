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

Route::prefix('home')->group(function () {
    Route::get('/', 'App\Http\Controllers\HomeController@response_index');
});

// API 接口代理
Route::match(['get', 'post', 'put', 'delete'], '/proxy', "\App\Http\Controllers\ApiController@proxy")->name('proxy');

Route::match(['get', 'post'], '/insert_{table}_list', "\App\Http\Controllers\ApiController@insert_list");
Route::match(['get', 'post'], '/delete_{table}_list', "\App\Http\Controllers\ApiController@delete_list");
Route::match(['get', 'post'], '/update_{table}_list', "\App\Http\Controllers\ApiController@update_list");
Route::match(['get', 'post'], '/select_{table}_list', "\App\Http\Controllers\ApiController@select_list");
Route::match(['get', 'post'], '/upsert_{table}_list', "\App\Http\Controllers\ApiController@upsert_list");
Route::match(['get', 'post'], '/faker_{table}_list', "\App\Http\Controllers\ApiController@faker_list");

Route::match(['get', 'post'], '/insert_{table}_item', "\App\Http\Controllers\ApiController@insert_item");
Route::match(['get', 'post'], '/delete_{table}_item', "\App\Http\Controllers\ApiController@delete_item");
Route::match(['get', 'post'], '/update_{table}_item', "\App\Http\Controllers\ApiController@update_item");
Route::match(['get', 'post'], '/select_{table}_item', "\App\Http\Controllers\ApiController@select_item");
Route::match(['get', 'post'], '/upsert_{table}_item', "\App\Http\Controllers\ApiController@upsert_item");
Route::match(['get', 'post'], '/increase_{table}_item', "\App\Http\Controllers\ApiController@increase_item");
Route::match(['get', 'post'], '/decrease_{table}_item', "\App\Http\Controllers\ApiController@decrease_item");
Route::match(['get', 'post'], '/import_{table}_content', "\App\Http\Controllers\ApiController@import_content");
Route::match(['get', 'post'], '/export_{table}_content', "\App\Http\Controllers\ApiController@export_content");
Route::match(['get', 'post'], '/staging_{table}_item', "\App\Http\Controllers\ApiController@staging_item");
Route::match(['get', 'post'], '/release_{table}_item', "\App\Http\Controllers\ApiController@release_item");
Route::match(['get', 'post'], '/faker_{table}_item', "\App\Http\Controllers\ApiController@faker_item");

Route::match(['get', 'post'], '/select_{table}_page', "\App\Http\Controllers\ApiController@select_page");


Route::match(['get', 'post'], '/artisan/{signature?}', "\App\Http\Controllers\ApiController@artisan");

Route::match(['get', 'post'], '/registor', "\App\Http\Controllers\ApiController@registor");
Route::match(['get', 'post'], '/login', "\App\Http\Controllers\ApiController@login");
Route::match(['get', 'post'], '/logout', "\App\Http\Controllers\ApiController@logout");
Route::match(['get', 'post'], '/forget_password', "\App\Http\Controllers\ApiController@forget_password");


/**
 * Meta
 */
// Route::match(['get', 'post'], '/insert_meta_list', "\App\Http\Controllers\ApiController@insert_meta_list");
// Route::match(['get', 'post'], '/delete_meta_list', "\App\Http\Controllers\ApiController@delete_meta_list");
// Route::match(['get', 'post'], '/update_meta_list', "\App\Http\Controllers\ApiController@update_meta_list");
// Route::match(['get', 'post'], '/select_meta_list', "\App\Http\Controllers\ApiController@select_meta_list");

// Route::match(['get', 'post'], '/insert_meta_item', "\App\Http\Controllers\ApiController@insert_meta_item");
// Route::match(['get', 'post'], '/delete_meta_item', "\App\Http\Controllers\ApiController@delete_meta_item");
// Route::match(['get', 'post'], '/update_meta_item', "\App\Http\Controllers\ApiController@update_meta_item");
// Route::match(['get', 'post'], '/select_meta_item', "\App\Http\Controllers\ApiController@select_meta_item");

// Route::match(['get', 'post'], '/select_meta_tree', "\App\Http\Controllers\ApiController@select_meta_tree");
/**
 * Content
 */
// Route::match(['get', 'post'], '/insert_content_list', "\App\Http\Controllers\ApiController@insert_content_list");
// Route::match(['get', 'post'], '/delete_content_list', "\App\Http\Controllers\ApiController@delete_content_list");
// Route::match(['get', 'post'], '/update_content_list', "\App\Http\Controllers\ApiController@update_content_list");
// Route::match(['get', 'post'], '/select_content_list', "\App\Http\Controllers\ApiController@select_content_list");
// Route::match(['get', 'post'], '/upsert_content_list', "\App\Http\Controllers\ApiController@upsert_content_list");
// Route::match(['get', 'post'], '/faker_content_list', "\App\Http\Controllers\ApiController@faker_content_list");

// Route::match(['get', 'post'], '/insert_content_item', "\App\Http\Controllers\ApiController@insert_content_item");
// Route::match(['get', 'post'], '/delete_content_item', "\App\Http\Controllers\ApiController@delete_content_item");
// Route::match(['get', 'post'], '/update_content_item', "\App\Http\Controllers\ApiController@update_content_item");
// Route::match(['get', 'post'], '/select_content_item', "\App\Http\Controllers\ApiController@select_content_item");
// Route::match(['get', 'post'], '/upsert_content_item', "\App\Http\Controllers\ApiController@upsert_content_item");
// Route::match(['get', 'post'], '/increase_content_item', "\App\Http\Controllers\ApiController@increase_content_item");
// Route::match(['get', 'post'], '/decrease_content_item', "\App\Http\Controllers\ApiController@decrease_content_item");
// Route::match(['get', 'post'], '/import_content', "\App\Http\Controllers\ApiController@import_content");
// Route::match(['get', 'post'], '/export_content', "\App\Http\Controllers\ApiController@export_content");
// Route::match(['get', 'post'], '/staging_content_item', "\App\Http\Controllers\ApiController@staging_content_item");
// Route::match(['get', 'post'], '/release_content_item', "\App\Http\Controllers\ApiController@release_content_item");
// Route::match(['get', 'post'], '/faker_content_item', "\App\Http\Controllers\ApiController@faker_content_item");
/**
 * Field
 */
// Route::match(['get', 'post'], '/insert_field_list', "\App\Http\Controllers\ApiController@insert_field_list");
// Route::match(['get', 'post'], '/delete_field_list', "\App\Http\Controllers\ApiController@delete_field_list");
// Route::match(['get', 'post'], '/update_field_list', "\App\Http\Controllers\ApiController@update_field_list");
// Route::match(['get', 'post'], '/select_field_list', "\App\Http\Controllers\ApiController@select_field_list");

// Route::match(['get', 'post'], '/insert_field_item', "\App\Http\Controllers\ApiController@insert_field_item");
// Route::match(['get', 'post'], '/delete_field_item', "\App\Http\Controllers\ApiController@delete_field_item");
// Route::match(['get', 'post'], '/update_field_item', "\App\Http\Controllers\ApiController@update_field_item");
// Route::match(['get', 'post'], '/select_field_item', "\App\Http\Controllers\ApiController@select_field_item");
/**
 * Comment
 */
// Route::match(['get', 'post'], '/insert_comment_list', "\App\Http\Controllers\ApiController@insert_comment_list");
// Route::match(['get', 'post'], '/delete_comment_list', "\App\Http\Controllers\ApiController@delete_comment_list");
// Route::match(['get', 'post'], '/update_comment_list', "\App\Http\Controllers\ApiController@update_comment_list");
// Route::match(['get', 'post'], '/select_comment_list', "\App\Http\Controllers\ApiController@select_comment_list");

// Route::match(['get', 'post'], '/insert_comment_item', "\App\Http\Controllers\ApiController@insert_comment_item");
// Route::match(['get', 'post'], '/delete_comment_item', "\App\Http\Controllers\ApiController@delete_comment_item");
// Route::match(['get', 'post'], '/update_comment_item', "\App\Http\Controllers\ApiController@update_comment_item");
// Route::match(['get', 'post'], '/select_comment_item', "\App\Http\Controllers\ApiController@select_comment_item");
/**
 * Link
 */
// Route::match(['get', 'post'], '/insert_link_list', "\App\Http\Controllers\ApiController@insert_link_list");
// Route::match(['get', 'post'], '/delete_link_list', "\App\Http\Controllers\ApiController@delete_link_list");
// Route::match(['get', 'post'], '/update_link_list', "\App\Http\Controllers\ApiController@update_link_list");
// Route::match(['get', 'post'], '/select_link_list', "\App\Http\Controllers\ApiController@select_link_list");

// Route::match(['get', 'post'], '/insert_link_item', "\App\Http\Controllers\ApiController@insert_link_item");
// Route::match(['get', 'post'], '/delete_link_item', "\App\Http\Controllers\ApiController@delete_link_item");
// Route::match(['get', 'post'], '/update_link_item', "\App\Http\Controllers\ApiController@update_link_item");
// Route::match(['get', 'post'], '/select_link_item', "\App\Http\Controllers\ApiController@select_link_item");
/**
 * Option
 */
// Route::match(['get', 'post'], '/insert_option_list', "\App\Http\Controllers\ApiController@insert_option_list");
// Route::match(['get', 'post'], '/delete_option_list', "\App\Http\Controllers\ApiController@delete_option_list");
// Route::match(['get', 'post'], '/update_option_list', "\App\Http\Controllers\ApiController@update_option_list");
// Route::match(['get', 'post'], '/select_option_list', "\App\Http\Controllers\ApiController@select_option_list");

// Route::match(['get', 'post'], '/insert_option_item', "\App\Http\Controllers\ApiController@insert_option_item");
// Route::match(['get', 'post'], '/delete_option_item', "\App\Http\Controllers\ApiController@delete_option_item");
// Route::match(['get', 'post'], '/update_option_item', "\App\Http\Controllers\ApiController@update_option_item");
// Route::match(['get', 'post'], '/select_option_item', "\App\Http\Controllers\ApiController@select_option_item");
/**
 * Log
 */
// Route::match(['get', 'post'], '/insert_log_list', "\App\Http\Controllers\ApiController@insert_log_list");
// Route::match(['get', 'post'], '/delete_log_list', "\App\Http\Controllers\ApiController@delete_log_list");
// Route::match(['get', 'post'], '/update_log_list', "\App\Http\Controllers\ApiController@update_log_list");
// Route::match(['get', 'post'], '/select_log_list', "\App\Http\Controllers\ApiController@select_log_list");

// Route::match(['get', 'post'], '/insert_log_item', "\App\Http\Controllers\ApiController@insert_log_item");
// Route::match(['get', 'post'], '/delete_log_item', "\App\Http\Controllers\ApiController@delete_log_item");
// Route::match(['get', 'post'], '/update_log_item', "\App\Http\Controllers\ApiController@update_log_item");
// Route::match(['get', 'post'], '/select_log_item', "\App\Http\Controllers\ApiController@select_log_item");
/**
 * User
 */
// Route::match(['get', 'post'], '/insert_user_list', "\App\Http\Controllers\ApiController@insert_user_list");
// Route::match(['get', 'post'], '/delete_user_list', "\App\Http\Controllers\ApiController@delete_user_list");
// Route::match(['get', 'post'], '/update_user_list', "\App\Http\Controllers\ApiController@update_user_list");
// Route::match(['get', 'post'], '/select_user_list', "\App\Http\Controllers\ApiController@select_user_list");

// Route::match(['get', 'post'], '/insert_user_item', "\App\Http\Controllers\ApiController@insert_user_item");
// Route::match(['get', 'post'], '/delete_user_item', "\App\Http\Controllers\ApiController@delete_user_item");
// Route::match(['get', 'post'], '/update_user_item', "\App\Http\Controllers\ApiController@update_user_item");
// Route::match(['get', 'post'], '/select_user_item', "\App\Http\Controllers\ApiController@select_user_item");