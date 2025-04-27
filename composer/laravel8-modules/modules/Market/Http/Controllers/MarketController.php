<?php

namespace Modules\Market\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Market\Models\MarketContent;
use Modules\Market\Support\Market;

class MarketController extends \App\Http\Controllers\Controller
{
    protected $module = "Market";
    protected $remote_projects;
    protected $remote_project;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('market::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('market::create');
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
        return view('market::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('market::edit');
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
    public function getRemote(Request $request, $remote): array
    {
        $remote_url = str_replace([
            "{\$search}",
            "{\$name}",
        ], [
            $request->input('search'),
            $request->input('name', ),
        ], \Arr::get($remote, 'url'));
        // var_dump($remote);
        // var_dump($remote_url);
        // 'response' => \Http::get('http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*jquery*')->json()
        $return = \Http::get($remote_url)->json();
        $return = \Arr::get($return, \Arr::get($remote, 'key'));
        $return = array_map(function ($item) use ($remote) {
            $res = ["_original" => $item];
            foreach (\Arr::get($remote, 'response.map') ?? [] as $result_key => $response_key) {
                // var_dump([$key, $response_key]);
                if (empty($response_key))
                    continue;
                $res[$result_key] = $item[$response_key];
            }
            return $res;
        }, $return ?? []);
        return $return;
    }
    public function getRemoteProject(Request $request)
    {
        if (!$request->filled('name'))
            return [];
        $return = $this->getRemote($request, $this->remote_project);
        if (is_array($return))
            $return = $return[0];
        return $return;
    }

    public function getRemoteProjects(Request $request)
    {
        if (!$request->filled('search'))
            return [];
        $return = $this->getRemote($request, $this->remote_projects);
        // var_dump($request->except('page'));
        $options = [
            "total" => sizeof($return),
            "current_page" => $request->input('page', 1),
            "per_page" => $request->input('size', 15),
            "path" => $request->url(),
            "query" => $request->except('page'),
            'fragment' => null
        ];
        $return = array_slice($return, ($options['current_page'] - 1) * $options['per_page'], $options['per_page']);

        return new LengthAwarePaginator($return, $options['total'], $options['per_page'], $options['current_page'], $options);
    }

    public static function admin_view($view = null, $data = [], $mergeData = [])
    {
        return self::view($view, $data, $mergeData);
    }
    function view_index(Request $request)
    {
        // $market = json_decode(app('files')->get('modules/Market/market.json'), true);
        // dump($market);
        $return = [
            'view' => 'index',
            // 'moduleProjects' => Http::get('http://api.github.com/orgs/ln-laravel-modular/repos')->json(),
            // 'exampleProjects' => Http::get('http://api.github.com/repos/ln-laravel-modular/example-packages/branches')->json(),
            // 'themeProjects' => Http::get('http://api.github.com/repos/ln-laravel-modular/theme-packages/branches')->json(),
        ];
        // return $this->view($return, $market);
        return $this->view($return);
    }
    function view_admin_modules(Request $request)
    {
        return self::admin_view('market::admin.modules');
    }
    function view_admin_modules_intro(Request $request, $module)
    {
        return self::admin_view('market::module.intro', ['module' => $module]);
    }
    function view_admin_modules_install(Request $request, $module)
    {
        return self::admin_view('market::module.install', ['module' => $module]);
    }
    function install_progress(Request $request)
    {
    }
    function install_progress_of_intro(Request $request)
    {
    }
    function install_progress_of_config(Request $request)
    {
    }
    function install_progress_of_table(Request $request)
    {
    }
    function install_progress_of_data(Request $request)
    {
    }
    function install_progress_of_result(Request $request)
    {
    }
}
