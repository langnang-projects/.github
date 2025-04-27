<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Nwidart\Modules\Facades\Module as FacadesModule;
use Nwidart\Modules\Laravel\Module as LaravelModule;
// use Nwidart\Modules\Module;
use App\Support\Module;

class AdminApiController extends \App\Http\Controllers\Controller
{
    protected $module = "Admin";
    function login(Request $request)
    {
        Auth::login(new User(['email' => $request->input('email'), 'password' => $request->input('password'),]), true);
    }
    function logout(Request $request)
    {
    }
    function api_modules_insert_item(Request $request)
    {
    }
    function api_modules_delete_item(Request $request)
    {
    }
    function api_modules_update_item(Request $request)
    {
    }
    function api_modules_select_list(Request $request)
    {
    }
}
