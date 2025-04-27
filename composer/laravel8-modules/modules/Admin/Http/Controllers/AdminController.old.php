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

class AdminController extends AdminApiController
{
    protected $module = "Admin";
    use ViewTrait, ViewWebTrait, ViewAdminTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::{__FUNCTION__}();
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public static function getSidebarMenu($menu = null, $parent = [])
    {
        // var_dump(__FUNCTION__);
        $menu = $menu ?? Module::allConfigCollapse('admin.sidebar');
        $actives = [];
        // order 排序
        usort($menu, function ($a, $b) {
            return Arr::get($a, 'order', 0) - Arr::get($b, 'order', 0);
        });
        // 当前路由地址
        $path = '/' . request()->path();
        // 当前路由正则
        $regex = request()->route()->compiled->getRegex();
        foreach ($menu as $index => &$item) {
            // 重置激活状态
            $item['active'] = false;
            $item['index'] = isset($menu['index']) ? ($menu['index'] . '-' . $index) : "$index";
            $item['path'] = isset($parent['path']) ? ($parent['path'] . $item['path']) : $item['path'];
            // 精准匹配
            if ($path == $item['path']) {
                $item['active'] = true;
                array_unshift($actives, $item);
            }
        }
        // 先精准匹配，然后模糊匹配
        // var_dump([$path, $uri]);
        foreach ($menu as $index => &$item) {
            // 判断当前路由地址是否以该地址开头
            // if(preg_match('/^' . str_replace('/', '\/', $item['path']) . '*/', $path));
            if (sizeof($actives) == 0 && (preg_match($regex, $item['path']) && substr($path, 0, strlen($parent['path'])) == $parent['path'])) {
                $item['active'] = true;
                array_unshift($actives, $item);
                // dump($regex, $parent['path'], $item['path']);
            }
            // var_dump(preg_match('/^' . str_replace('/', '\/', $item['path']) . '*/', $path));
            if (!empty($item['children']) && $item['active'] == false) {
                [$item['children'], $activeTree] = self::getSidebarMenu($item['children'], $item);
                // 根据子元素修改父元素
                $hasActiveChild = sizeof(array_filter($item['children'], function ($subItem) {
                    return !empty($subItem['active']);
                })) > 0;
                if ($hasActiveChild) {
                    $item['active'] = true;
                    $actives = $activeTree;
                    array_unshift($actives, $item);
                    // var_dump($item);
                }
            }
        }
        // var_dump($actives);
        return [$menu, $actives];
    }

    public function view($view = null, $data = [], $mergeData = [])
    {
        // var_dump($this->getSidebarMenu());
        $config = Module::currentConfig();
        [$config['menu'], $config['menu_actives']] = self::getSidebarMenu(null, ['path' => '/admin']);
        // var_dump(request()->path());
        // var_dump(request()->route());
        // var_dump($module_config['menu']);
        // dump($module_config['menu']);
        return parent::view($view, array_merge(['config' => $config], $data, $mergeData));
    }


    public function view_content_list(Request $request)
    {
        $request->merge(['$view' => 'ssential.content-list']);
        return parent::{__FUNCTION__}($request);
    }
    public function view_content_item(Request $request, $cid = 0)
    {
        $request->merge(['$view' => 'ssential.content-item']);
        if ($request->method() == 'GET') {
        }

        if ($request->method() == 'POST') {
            // insert_item
            // update_item
        }
        return parent::{__FUNCTION__}($request, $cid);
    }
}

trait ActionTrait
{
}

trait ViewTrait
{
    function view_register(Request $request)
    {
        $return = [
            'view' => "register"
        ];
        return $this->view($return);
    }
    function view_login(Request $request)
    {
        if ($request->method() == 'POST') {
            $this->api_login($request);
            if (Auth::check())
                return redirect("/admin");
        }
        $return = [
            'view' => "login"
        ];
        return $this->view($return);
    }
    function view_forgot_password(Request $request)
    {
        $return = [
            'view' => "forgot-password"
        ];
        return $this->view($return);
    }
    function view_dashboard_index(Request $request)
    {
        $return = [
            'view' => "dashboard.index",
            "count" => [
                "user" => $this->select_count($request, 'user'),
                "meta" => $this->select_count($request, 'meta'),
                "link" => $this->select_count($request, 'link'),
                "content" => $this->select_count($request, 'content'),
                "field" => $this->select_count($request, 'field'),
                "comment" => $this->select_count($request, 'comment'),
            ],
        ];
        return $this->view($return);
    }
    function view_dashboard_index2(Request $request)
    {
        $return = [
            'view' => "dashboard.index2"
        ];
        return $this->view($return);
    }
    function view_dashboard_index3(Request $request)
    {
        $return = [
            'view' => "dashboard.index3"
        ];
        return $this->view($return);
    }
    function view_index(Request $request)
    {

        // if (!Auth::check()) return redirect("/admin/login");
        $return = [
            'view' => "index"
        ];
        return $this->view($return);
    }
    function view_index2(Request $request)
    {
        return $this->view('admin::index2');
    }
    function view_index3(Request $request)
    {
        return $this->view('admin::index3');
    }

    function view_config(Request $request)
    {
        return $this->view('admin::admin.config.index');
    }
    function view_module_market(Request $request)
    {
        return $this->view('admin::market.index');
    }
    function view_module_market_intro(Request $request, $slug)
    {
        return $this->view('admin::market.module-intro', [
            'slug' => $slug,
        ]);
    }
    function view_module_market_install(Request $request, $slug)
    {
        $_GET['step'] = $_GET['step'] ?? 1;
        return $this->view('admin::market.module-install', [
            'slug' => $slug,
        ]);
    }
    function view_module_installed(Request $request)
    {
        return $this->view('admin::market.index');
    }
}

trait ViewWebTrait
{
}

trait ViewAdminTrait
{
    public function view_admin_basic_index(Request $request)
    {
        $return = [
            'view' => 'basic.index',
            'paginator' => \Modules\Admin\Models\BasicContent::paginate(10),
        ];
        return $this->view($return);
    }
    public function view_admin_modules_index(Request $request, $module)
    {
        $return = [
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.modules.index',
            'moduleConfig' => Module::currentConfig(null, $module, 'files'),
            'method' => 'view_admin_index',
            // 'jsdelivrs' => Http::get('http://ssential.jsdelivr.com/v1/stats/packages')->json()
        ];
        foreach (Arr::get($return, 'moduleConfig.controllers') as $controller) {
            if (strtolower(basename($controller)) === strtolower(Arr::get($return, 'moduleConfig.name') . 'AdminController')) {
                $return['moduleController'] = $controller;
                break;
            }
        }
        if (isset($return['moduleController'])) {
            // return $this->__call();
            return call_user_func([new $return['moduleController'], $return['method']], $request, $return);
        }
        // var_dump(Arr::get($return['moduleConfig'], 'controllers'));
        // var_dump(Arr::get($return['moduleConfig'], 'name') . 'AdminController');
        // $response = Http::get('http://ssential.jsdelivr.com/v1/stats/packages');
        // var_dump($response->json());
        return $this->view($return['view'], $return);
    }
    // 通用模块数据新增视图
    function view_admin_modules_insert_item(Request $request, $module, $table)
    {
        $return = [
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.modules.' . substr($table, 0, -1),
            'moduleConfig' => Module::currentConfig(null, $module, 'files'),
            'moduleModels' => Module::currentConfig('entities', $module, true),
            'method' => 'view_admin_insert_item',
        ];
        // var_dump($return);
        foreach ($return['moduleModels'] as $entity) {
            if (strtolower(basename($entity)) === strtolower($module . substr($table, 0, -1))) {
                $return['moduleEntity'] = $entity;
                break;
            }
        }
        if (empty($return['moduleEntity']))
            abort(404);
        $return['ModuleTableDetail'] = new $return['moduleEntity'];
        if ($request->method() == 'POST') {
            $return['ModuleTableDetail']->fill($request->input());
            $return['ModuleTableDetail']->save();
            $id = $return['ModuleTableDetail']->{$return['detail']->getKeyName()};
            return redirect("/admin/" . $module . "/" . $table . '/' . $id);
        }

        return $this->view($return['view'], $return);
    }
    // 通用模块数据详情视图
    function view_admin_modules_select_item(Request $request, $module, $table, $id)
    {
        $return = [
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.modules.' . substr($table, 0, -1),
            'moduleModels' => Module::currentConfig('entities', $module, 'files'),
            'method' => 'view_admin_select_item',
        ];
        foreach ($return['moduleModels'] as $entity) {
            if (strtolower(basename($entity)) === strtolower($module . substr($table, 0, -1))) {
                $return['moduleEntity'] = $entity;
                break;
            }
        }
        if (empty($return['moduleEntity']))
            abort(404);
        $return['ModuleTableDetail'] = $return['entity']::find($id);
        if ($request->method() == 'POST') {
            $return['ModuleTableDetail']->fill($request->input());
            $return['ModuleTableDetail']->save();
        }
        return $this->view($return['view'], $return);
    }
    // 通用模块数据查询视图
    function view_admin_modules_select_list(Request $request, $module, $table)
    {

        $return = [
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.modules.' . $table,
            'moduleModels' => Module::currentConfig('entities', $module, 'files'),
        ];
        foreach ($return['moduleModels'] as $entity) {
            if (strtolower(basename($entity)) === strtolower($module . substr($table, 0, -1))) {
                $return['moduleEntity'] = $entity;
                break;
            }
        }
        // var_dump($return);
        if (empty($return['moduleEntity']))
            abort(404);
        $return['moduleTablePaginator'] = $return['moduleEntity']::paginate(15);
        return $this->view($return['view'], $return);
    }

    // TODO:通用模块参数配置视图
    function view_admin_system_modules_config(Request $request, $module = null)
    {
        if (empty($module))
            $module = Module::current();
        $return = [
            // 'prefix' => '',
            // 'files' => app('files')->allFiles('modules\\' . Module::currentConfig('name', $module)),
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.system.modules.config',
            'moduleConfig' => Module::currentConfig(null, $module, 'files'),
            'structure' => [],
        ];
        try {
            // var_dump($test);
            if ($request->method() == 'POST') {
                // var_dump($request->input());

                if (in_array($request->input('_target'), array_keys(config('modules.config.update-keys')))) {
                    foreach (config('modules.config.update-keys.' . $request->input('_target')) as $key) {
                        Arr::set($return['moduleConfig'], $key, $request->input(Str::of($key)->replace('.', '_'), Module::currentConfig($key, $module)));
                        // $return['moduleConfig'][$key] = $request->input($key, Module::currentConfig($key, $module));
                    }
                    Module::setCurrentConfig(null, $return['moduleConfig'], $module);
                    $return['alert'] = ['type' => 'success', 'message' => 'Update config successfully!'];
                }

                if (in_array($request->input('_target'), array_keys(config('modules.config.commands')))) {
                    $target = $request->input('_target');
                    if (Str::startsWith($target, 'make-')) {
                        $request->merge([
                            'cmd' => 'module:'
                                . $request->input('_target')
                                . ' '
                                . $request->input('make-prepend')
                                . $request->input(Str::of($request->input('_target'))->after('make-'))
                                . $request->input('make-append')
                                . ' '
                                . Module::currentConfig('name', $module)
                        ]);
                        Artisan::call($request->input('cmd'));
                        $return['alert'] = ['type' => 'success', 'message' => Artisan::output()];
                    }

                    $return['moduleConfig'] = Module::currentConfig(null, $module, 'files');
                    // $request->
                    //     Artisan::call('module:' . $request->input('_target'),  [
                    //         'module' => Module::currentConfig('name', $module),
                    //         'command' => $request->input('command'),
                    //         'model' => $request->input('model'),
                    //     ]);
                    //     var_dump(Module::setCurrentConfig(null, $return['config'], $module));
                    // }
                    // switch ($request->input('_target')) {
                    //     case 'make-model':
                    //
                    //         // $res = new \Nwidart\Modules\Commands\ModelMakeCommand;
                    //         // var_dump($res->handle('ToDoMeta ToDo'));
                    //         Artisan::call('module:make-model', [
                    //             'model' => "ToDoMeta",
                    //             'module' => "ToDo"
                    //         ]);
                    //         break;
                    //     default:
                    //         break;
                }
            }



            // foreach ($return['files'] as $file) {
            //     foreach (config('modules.config.files') ?? [] as $key => $path) {
            //         if (!isset($return[$key])) $return[$key] = [];
            //         if (substr($file->getRelativePathName(), 0, strlen($path)) == $path) {
            //             array_push($return[$key], $file);
            //             break;
            //         }
            //     }
            // }

            // var_dump($request->input());
            // var_dump($return['moduleConfig']);

        } catch (Exception $e) {
            $return['alert'] = ['type' => 'error', 'message' => $e->getMessage()];
        }
        // var_dump($return);*
        return $this->view($return['view'], $return);
    }
    function view_admin_system_database(Request $request, $table = null)
    {
        $return = [
            'view' => 'system.database',
            'tables' => \DB::table('information_schema.tables')->where('table_schema', env('DB_DATABASE'))->get(),
            'columns' => empty($table) ? [] : \DB::table('information_schema.columns')->where([
                ['table_schema', env('DB_DATABASE')],
                ['table_name', $table],
            ])->get(),
        ];

        return $this->view($return);
    }
    function view_system_artisan(Request $request, $part = null)
    {
        Artisan::call('list');
        $return = [
            '$dir' => __DIR__,
            '$file' => __FILE__,
            '$line' => __LINE__,
            '$method' => __METHOD__,
            '$function' => __FUNCTION__,
            '$class' => __CLASS__,
            '$request' => $request->all(),
            'view' => 'system.artisan',
            'artisan_list' => Artisan::output(),
            // 'commands' => preg_split("/\\n/", Artisan::output()),
        ];
        // $return['artisan_list'] = preg_replace(['/ /'], ['&nbsp;'], $return['artisan_list']);
        $return['commands'] = array_map(function ($item) {
            $res = [
                "command" => preg_replace(['/ /'], ['&nbsp;'], $item),
                "is_group" => false,
                "is_category" => false,
                "signature" => "",
                "description" => "",
            ];
            if (substr($item, 0, 2) === '  ') {
                $res['signature'] = substr($item, 2, strripos($item, '  '));
                $res['description'] = empty($res['signature']) ? $item : substr($item, strripos($item, '  ') + 2);
            } else if (substr($item, 0, 1) === ' ') {
                $res["is_category"] = true;
            } else {
                $res["is_group"] = true;
            }
            return $res;
        }, preg_split("/\\n/", $return['artisan_list']));
        // var_dump($return['commands']);
        // var_dump($return['commands']);
        // var_dump(preg_split("/\\n/", $return['commands'], ));
        // explode("\n", Artisan::output())
        // var_dump($return);
        return $this->view($return);
    }
    public function view_admin_system_modules(Request $request)
    {
        $return = [
            'view' => 'admin::admin.' . Module::currentConfig('layout') . '.system.modules.index',
            'modules' => FacadesModule::all(),
        ];
        return $this->view($return['view'], $return);
    }

    public function view_system_helpers(Request $request)
    {
        $return = [
            'view' => 'system.helpers',
            'declaredClasses' => array_slice(get_declared_classes(), 0, 10),
        ];
        return $this->view($return);
    }
    public function view_system_helpers_class(Request $request, $class)
    {
        $return = [
            'view' => 'system.helpers',
            'classMethods' => get_class_methods($class),
        ];
        return $this->view($return);
    }
}