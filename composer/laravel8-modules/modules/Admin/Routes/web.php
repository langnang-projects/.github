<?php

use App\Support\Helpers\ModuleHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Controllers\AdminController;
use App\Support\Module;

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

// var_dump(Module::current());
// var_dump(Module::currentConfig('name'));
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index');

    Route::prefix('ssential')->group(function () {
        Route::prefix('metas')->group(function () {
            Route::get('/', 'AdminMetaController@index');
            Route::post('/', 'AdminMetaController@import');

            Route::get('/create', 'AdminMetaController@create');
            Route::post('/create', 'AdminMetaController@store');

            Route::get('/factory', 'AdminMetaController@factory');
            Route::post('/factory', 'AdminMetaController@store');

            Route::get('/{id}', 'AdminMetaController@edit');
            Route::post('/{id}', 'AdminMetaController@update');

            Route::post('/delete/{id}', 'AdminMetaController@destroy');

            Route::post('/import/{id}', 'AdminMetaController@import');

            Route::get('/list', 'AdminMetaController@list');
        });
        Route::prefix('contents')->group(function () {
            Route::get('/', 'AdminContentController@index');
            Route::get('/create', 'AdminContentController@create');
            Route::post('/create', 'AdminContentController@store');

            Route::get('/factory', 'AdminContentController@factory');
            Route::post('/factory', 'AdminContentController@store');

            Route::get('/{id}', 'AdminContentController@edit');
            Route::post('/{id}', 'AdminContentController@update');


            Route::post('/delete/{id}', 'AdminContentController@destroy');

            Route::get('/list', 'AdminContentController@list');

        });

        Route::prefix('links')->group(function () {
            Route::get('/', 'AdminLinkController@index');
            Route::get('/create', 'AdminLinkController@create');
            Route::post('/create', 'AdminLinkController@store');
            Route::get('/{id}', 'AdminLinkController@edit');
            Route::post('/{id}', 'AdminLinkController@update');
            Route::post('/delete/{id}', 'AdminLinkController@destroy');

        });
    });

    Route::prefix('modules')->group(function () {

        foreach (Module::allEnabled() as $moduleName => $moduleObject) {
            $moduleAdminController = "\Modules\\$moduleName\Http\Controllers\\$moduleName" . "AdminController";
            $moduleAdminController = class_exists($moduleAdminController) ? $moduleAdminController : "\Modules\Admin\Http\Controllers\AdminContentController";
            Route::prefix($moduleObject->getAlias())->group(function () use ($moduleAdminController) {
                Route::get('/', [$moduleAdminController, 'index']);

                Route::get('/create', [$moduleAdminController, 'create']);
                Route::post('/create', [$moduleAdminController, 'store']);

                Route::get('/factory', [$moduleAdminController, 'factory']);
                Route::post('/factory', [$moduleAdminController, 'store']);

                Route::get('/{id}', [$moduleAdminController, 'edit']);
                Route::post('/{id}', [$moduleAdminController, 'update']);

                Route::post('/delete/{id}', [$moduleAdminController, 'destroy']);

                Route::get('/list', [$moduleAdminController, 'list']);
            });
        }
    });



    // Route::match(['get', 'post'], '/register', 'AdminController@view_register');
    // Route::match(['get', 'post'], '/login', 'AdminController@view_login');
    // Route::match(['get', 'post'], '/forgot-password', 'AdminController@view_forgot_password');
    // Route::get('/config', 'AdminController@view_config');
    // Route::get('/basic', 'AdminController@view_admin_basic_index');

    // Route::prefix('dashboard')->group(function () {
    //     Route::match(['get',], '/index', 'AdminController@view_dashboard_index');
    //     Route::match(['get',], '/index2', 'AdminController@view_dashboard_index2');
    //     Route::match(['get',], '/index3', 'AdminController@view_dashboard_index3');
    // });

    // Route::prefix('data')->group(function () {
    //     Route::match(['get', 'post'], '/meta', 'AdminController@view_meta_list');
    //     Route::match(['get', 'post'], '/meta/{id}', 'AdminController@view_meta_item');
    //     Route::match(['get', 'post'], '/meta/insert', 'AdminController@view_meta_item');

    //     Route::match(['get', 'post'], '/content', 'AdminController@view_content_list');
    //     Route::match(['get', 'post'], '/content/{id}', 'AdminController@view_content_item');
    //     Route::match(['get', 'post'], '/content/{id}/{field}', 'AdminController@view_field_item');
    //     // Route::match(['get', 'post'], '/content/insert', 'AdminController@view_content_item');

    //     Route::match(['get', 'post'], '/comment', 'AdminController@view_comment_list');
    //     Route::match(['get', 'post'], '/comment/{id}', 'AdminController@view_comment_item');
    //     Route::match(['get', 'post'], '/comment/insert', 'AdminController@view_comment_item');

    //     Route::match(['get', 'post'], '/link', 'AdminController@view_link_list');
    //     Route::match(['get', 'post'], '/link/{id}', 'AdminController@view_link_item');
    //     Route::match(['get', 'post'], '/link/insert', 'AdminController@view_link_item');
    // });


    // Route::prefix('system')->group(function () {
    //     // view_admin_system_database
    //     Route::match(['get', 'post'], '/database', 'AdminController@view_admin_system_database');
    //     Route::match(['get', 'post'], '/database/{table?}', 'AdminController@view_admin_system_database');

    //     Route::match(['get', 'post'], '/artisan', 'AdminController@view_system_artisan');

    //     Route::match(['get', 'post'], '/config', 'AdminController@view_admin_modules_config');
    //     Route::match(['get'], '/modules', 'AdminController@view_admin_system_modules');
    //     Route::match(['get', 'post'], '/modules/{table}', 'AdminController@view_admin_system_modules_config')
    //         ->where([
    //             'module' => '(' . implode('|', array_filter(array_values(Module::allConfig('web.prefix')), function ($value) {
    //                 return $value !== strtolower(Module::current());
    //             })) . ')'
    //         ]);
    //     Route::match(['get'], '/helpers', 'AdminController@view_system_helpers');
    //     Route::match(['get'], '/helpers/{class}', 'AdminController@view_system_helpers_class');
    // });

    /**
     * TODO 根据模块配置自动
     */
    // Route::prefix('{module}')
    //     ->where([
    //         'module' => '(' . implode('|', array_filter(array_values(Module::allConfig('web.prefix')), function ($value) {
    //             return $value !== strtolower(Module::current());
    //         })) . ')'
    //     ])
    //     ->group(function () {
    //         Route::match(['get', 'post'], '', 'AdminController@view_admin_modules_index');
    //         Route::prefix('{table}')->where(['table' => '(metas|contents|comments|links)'])->group(function () {
    //             Route::get('', 'AdminController@view_admin_modules_select_list');

    //             Route::match(['get', 'post'], '/insert', 'AdminController@view_admin_modules_insert_item');

    //             Route::match(['get', 'post'], '/{id}', 'AdminController@view_admin_modules_select_item')->where(['id' => '[0-9]+']);
    //         });
    //     });
    // Route::match(['get', 'post'], '/config', 'AdminController@view_admin_modules_config');
    // Route::prefix('module-market')->group(function () {
    //     Route::get('/', 'AdminController@view_module_market');
    //     Route::get('/{slug}', 'AdminController@view_module_market_intro');
    //     Route::get('/{slug}/install', 'AdminController@view_module_market_install');
    // });
    // Route::get('/module-installed', 'AdminController@view_module_installed');

    // Route::prefix('{module}')->group(function () {
    //     Route::prefix('{table}')->where(['table' => '(metas|contents|comments|links)'])->group(function () {
    //         Route::get('/insert', function (Request $request, $module, $table) {
    //             $return = [
    //                 'view' => 'admin::admin.modules.' . substr($table, 0, -1),
    //             ];
    //             return AdminController::view($return['view'], $return);
    //         });

    //         Route::get('/{id}', function (Request $request, $module, $table, $id) {
    //             $return = [
    //                 'view' => 'admin::admin.modules.' . substr($table, 0, -1),
    //                 'readonly' => true,
    //             ];
    //             $return['detail'] = DB::table('video_contents')->where('cid', $id)->first();
    //             return AdminController::view($return['view'], $return);
    //         });
    //         Route::get('', function (Request $request, $module, $table, $id = null) {
    //             $return = [
    //                 'view' => 'admin::admin.modules.' . $table,
    //                 'readonly' => true,
    //             ];

    //             $return['paginator'] = DB::table('video_contents')->paginate(15);
    //             return AdminController::view($return['view'], $return);
    //         });
    //     });
    //     Route::get('/options', function (Request $request, $module) {
    //         return AdminController::view('admin::admin.modules.options');
    //     });
    //     Route::get('/themes', function (Request $request, $module) {
    //         return AdminController::view('admin::admin.modules.themes');
    //     });
    //     Route::get('/extras', function (Request $request, $module) {
    //         return AdminController::view('admin::admin.modules.extras');
    //     });
    // });
    // Route::get('/update/{id}', function (Request $request, $module, $table, $id) {
    //     $return = [
    //         'view' => 'admin::admin.modules.' . substr($table, 0, -1),
    //     ];
    //     return AdminController::view($return['view'], $return);
    // });
    // Route::get('/{module}/contents/{parentCid?}', function (Request $request, $module, $parentCid = null) {
    //     return AdminController::view('admin::modules.contents');
    // });
    // Route::get('/{module}/metas/{parentMid?}', function (Request $request, $module, $parentMid = null) {
    //     $metas = \App\Models\Meta::paginate(20);
    //     return AdminController::view('admin::modules.metas', ['module' => $module, 'parentMid' => $parentMid, 'metas' => $metas]);
    // });
    // Route::get('/{module}/metas/{mid?}', function (Request $request, $module) {
    //     return AdminController::view('admin::modules.meta');
    // });
    // Route::get('/{module}/contents/{parentCid?}', function (Request $request, $module, $parentCid = null) {
    //     return AdminController::view('admin::modules.contents');
    // });
    // Route::get('/{module}/content/{cid?}', function (Request $request, $module) {
    //     return AdminController::view('admin::modules.content');
    // });
    // Route::get('/{module}/links/{parentLid?}', function (Request $request, $module, $parentLid = null) {
    //     return AdminController::view('admin::modules.content');
    // });
    // Route::get('/{module}/link/{lid?}', function (Request $request, $module, $lid) {
    //     return AdminController::view('admin::modules.link');
    // });

});