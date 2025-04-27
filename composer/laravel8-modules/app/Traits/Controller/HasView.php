<?php

namespace App\Traits\Controller;

use Illuminate\Http\Request;
use App\Support\Module;
use Illuminate\Support\Facades\View;

trait HasView
{
    /**
     * Summary of view
     * @param mixed $view
     * @param mixed $data
     * @param mixed $mergeData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view($view = null, $data = [], $mergeData = [])
    {
        try {
            $return = array_merge([
                '$servers' => [],
                '$constants' => [],
                '$variables' => [
                    'route' => [
                        'method' => request()->method(),
                        'url' => request()->url(),
                        'fullUrl' => request()->fullUrl(),
                        'path' => request()->path(),
                        'pathInfo' => request()->getPathInfo(),
                    ],
                    'request' => request()->all(),
                ],
                '$route' => [
                    'method' => request()->method(),
                    'url' => request()->url(),
                    'fullUrl' => request()->fullUrl(),
                    'path' => request()->path(),
                    'pathInfo' => request()->getPathInfo(),
                ],
                '$request' => request()->all(),
                '$logs' => $this->getLogs(),
                'config' => $config = Module::currentConfig(null, $this->module),
                'layout' => "layouts.master",
            ], is_array($view) ? $view : ['view' => $view], $data);

            // var_dump(self::class);
            // var_dump($config);
            //
            // var_dump($return);
            // $return['layout'] = empty($config) ? $return['layout'] : $config['slug'] . '::layouts.' . $config['layout'];
            // 
            // var_dump($return);
            // $return['view'] = is_array($view)
            //     ? (empty($config)
            //         ? $return['view']
            //         : $config['slug'] . '::' . $config['slug'] . '.' . $config['layout'] . '.' . $return['view'])
            //     : $this->match_view($view);
            $return['layout'] = $this->match_layout(empty($config) ? $return['layout'] : $config['layout']);
            // var_dump($return);
            $return['view'] = $this->match_view($return['view'], empty($config) ? $return['layout'] : $config['layout']);
            // var_dump($return);
            // var_dump($return);
            $this->prependLogs(['method' => __METHOD__, "layout" => $return["layout"], "view" => $return["view"],]);
            $return['$logs'] = $this->getLogs();

            if (env('WEB_CONSOLE')) {
                echo "<script>window.\$app=" . json_encode($return, JSON_UNESCAPED_UNICODE) . ";</script>";
                echo "<script>console.log('window.\$app',window.\$app);</script>";
            }
            // var_dump($return);
            // if (is_array($view) ? !isset($view['view']) : empty($view))
            //     abort(404);

            // if (!\View::exists($return['view']))
            //     abort(404);
            \Log::channel('mysql')->debug(request()->getPathInfo(), [
                "route" => $return['$route'],
                "request" => $return['$request'],
                "layout" => $return["layout"],
                "view" => $return["view"],
                "logs" => $return['$logs'],
            ]);
            // var_dump($log);
            return view($return['view'], $return, $mergeData);
        } catch (\Exception $e) {
            \Log::channel('mysql')->error($e->getMessage() . $e->getFile() . $e->getTraceAsString());
            abort(503);
        }

    }

    public function match_layout($layout = 'master', $module = null)
    {
        $module = strtolower(empty($module) ? $this->module : $module);
        // $module = is_linux() ? (empty($module) ? $this->module : $module) : (strtolower(empty($module) ? $this->module : $module));
        $moduleLayout = $module . '::layouts.' . $layout;
        $globalLayout = 'layouts.' . $layout;
        $log = [
            "method" => __METHOD__,
            "module" => $module,
            "layout" => $layout,
            "exists_layout" => View::exists($layout),
            "moduleLayout" => $moduleLayout,
            "exists_moduleLayout" => [View::exists($moduleLayout), module_path($module, config('modules.paths.generator.views-layout.path') . DIRECTORY_SEPARATOR . $layout . '.blade.php'), file_exists(module_path($module, config('modules.paths.generator.views-layout.path') . DIRECTORY_SEPARATOR . $layout . '.blade.php'))],
            // "exists_moduleLayout" => [View::exists($moduleLayout), module_path($module, 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.blade.php'), file_exists(module_path($module, 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.blade.php'))],

            "globalLayout" => $globalLayout,
            "exists_globalLayout" => [View::exists($globalLayout),],
        ];
        // if (View::exists($moduleLayout) || file_exists(module_path($module, config('modules.paths.generator.views-layout.path') . DIRECTORY_SEPARATOR . $layout . '.blade.php'))) {
        if (View::exists($moduleLayout)) {
            $this->prependLogs(array_merge($log, ['return' => $moduleLayout]));
            return $moduleLayout;
        }
        // 全局模板页面
        else if (View::exists($globalLayout)) {
            $this->prependLogs(array_merge($log, ['return' => $globalLayout]));
            return $globalLayout;
        } else if (View::exists($layout)) {
            $this->prependLogs(array_merge($log, ['return' => $layout]));
            return $layout;
        } else {
            $this->prependLogs(array_merge($log, ['return' => null]));
            abort(404, "No Layout");
        }
    }
    public function match_view($view, $layout = 'master', $module = null)
    {
        $module = strtolower(empty($module) ? $this->module : $module);
        // $module = is_linux() ? (empty($module) ? $this->module : $module) : (strtolower(empty($module) ? $this->module : $module));
        $moduleView = $module . '::' . $module . '.' . $layout . '.' . $view;
        $globalView = 'pages.' . $layout . '.' . $view;
        // var_dump([$view, $layout, $module, $moduleView, $globalView]);
        $log = [
            "method" => __METHOD__,
            "module" => $module,
            "view" => $view,
            "exists_view" => [View::exists($view)],
            "layout" => $layout,
            "exists_layout" => [View::exists($layout)],
            "moduleView" => $moduleView,
            "exists_moduleView" => [View::exists($moduleView), module_path($module, config('modules.paths.generator.views.path') . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $layout . DIRECTORY_SEPARATOR . $view . '.blade.php'), file_exists(module_path($module, config('modules.paths.generator.views.path') . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $layout . DIRECTORY_SEPARATOR . $view . '.blade.php'))],
            "globalView" => $globalView,
            "exists_globalView" => [View::exists($globalView)],
        ];
        // 模块定制页面
        // if (View::exists($moduleView) || file_exists(module_path($module, config('modules.paths.generator.views.path') . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $layout . DIRECTORY_SEPARATOR . $view . '.blade.php'))) {
        if (View::exists($moduleView)) {
            $this->prependLogs(array_merge($log, ['return' => $moduleView]));
            return $moduleView;
        }
        // 全局模板页面
        else if (View::exists($globalView)) {
            $this->prependLogs(array_merge($log, ['return' => $globalView]));
            return $globalView;
        } else if (View::exists($view)) {
            $this->prependLogs(array_merge($log, ['return' => $view]));
            return $view;
        } else {
            abort(404, 'No View');
        }
    }
    // public function view_index(Request $request)
    // {
    //     $return = ['view' => 'home.index'];
    //     return $this->view($return);
    // }
    public function view_on_request(Request $request, $table, $method = null)
    {
    }
    public function view_on_response(Request $request, $table, $method = null)
    {
    }
    /**
     * OPEN /{prefix}
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_index(Request $request)
    {
        // dump(Auth::check());
        // Auth::loginUsingId(1, true);
        $log = [__METHOD__, $request->all()];
        // $user = $this->UserModel::find(1);
        // dump($user);
        // Auth::login($user, true);
        $return = array_merge([
            "query" => $request->all(),
            'view' => $request->input('$view', 'index'),
            "page" => $request->input('page', '1'),
            "size" => $request->input('size', '20'),
            "last_page" => 1,
        ], $request->input('$return', []), );

        // $return['contents'] = \App\Models\Content::with(['fields']);
        // if (!in_array($this->module, ['Home', 'Admin'])) {
        //     $return['contents'] = $return['contents']->whereHas("fields", function ($query) {
        //         $query->where([['name', 'module_' . strtolower($this->module)]]);

        //     });
        // }
        // $return['contents'] = $return['contents']->paginate($return['size']);
        $return['contents'] = $this->select_list($request, 'content', [
            'whereHas' => [
                'fields',
                function ($query) {
                    $query->where([['name', 'module_' . strtolower($this->module)]]);

                }
            ]
        ]);
        // $return['logs'] = $this->getL;

        return $this->view($return);

        $query = $return['$query'] ?? [];
        unset($return['query']['$return']);
        // 清除分页，便于生成分页地址
        unset($return['query']['page_size'], $return['query']['page']);
        if (!isset($return['categories'])) {
            array_push($_logs, "parent not set categories.");
            $query['categories'] = array_merge([], $query['categories'] ?? []);
            $return['categories'] = $this->get_view_categories(new Request([]));
        }
        if (!isset($return['tags'])) {
            $query['tags'] = array_merge([], $query['tags'] ?? []);
            $return['tags'] = $this->get_view_tags(new Request([]));
        }
        if ($request->hasAny(['mid', 'mids'])) {
            $query['metas'] = array_merge([
                'mid' => $request->input('mid'),
                'mids' => explode(',', $request->input('mids')),
                "page_size" => PHP_INT_MAX
            ], $query['metas'] ?? []);
            $return['metas'] = $this->getReturn($this->select_meta_list(new Request($query['metas'])));
        }
        if (isset($return['content']) || $request->filled('cid')) {
            array_push($_logs, "parent set content or filled cid.");
            if (!isset($return['content']) && $request->filled('cid')) {
                $query['content'] = array_merge(['cid' => $request->input('cid')], $query['metas'] ?? []);
                $return['content'] = $this->getReturn($this->select_content_item(new Request($query['content'])));
            }
            unset($return['current_page'], $return['last_page']);
        } else if (!isset($return['contents'])) {
            array_push($_logs, "parent not set contents.");
            $query['contents'] = array_merge([
                'title' => $request->input('title'),
                'type' => $request->input('type', 'post'),
                'mid' => $request->input('mid'),
                'mids' => explode(',', $request->input('mids', '')),
                'status' => $request->input('status'),
                'page_size' => $request->input('page_size', 30),
                '$order' => ['updated_at'],
            ], $query['contents'] ?? []);
            $return['contents'] = $this->getReturn($this->select_content_list(new Request($query['contents'])));
            unset($return['query']['mid'], $return['query']['mids']);
            // var_dump($return['contents']);
        }
        if (isset($return['contents']) && $return['contents'] instanceof Paginator) {
            $return['last_page'] = $return['contents']->lastPage();
        }
        if (!isset($return['latest_contents'])) {
            $query['latest_contents'] = array_merge([], $query['latest_contents'] ?? []);
            $return['latest_contents'] = $this->get_view_latest_contents(new Request([]));
            // var_dump($return['latest_contents']);
        }
        if (!isset($return['toplist_contents'])) {
            $query['toplist_contents'] = array_merge([], $query['toplist_contents'] ?? []);
            $return['toplist_contents'] = $this->get_view_toplist_contents(new Request([]));
            // var_dump($return['toplist_contents']);
        }
        if (!isset($return['links'])) {
            $query['links'] = array_merge([], $query['links'] ?? []);
            $return['links'] = $this->getReturn($this->select_link_list(new Request()));
        }
        $return['$query'] = $query;
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }
    /**
     * Summary of view_hunt
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function view_hunt(Request $request)
    {
        $return = ['view' => "hunt"];
        return $this->view($return);
    }
    /**
     * Summary of view_find
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function view_find(Request $request)
    {
        $return = array_merge(['view' => 'find'], $request->input('$return', []));

        $return['contents'] = $this->select_list($request, 'content', [
            'whereHas' => [
                'fields',
                function ($query) {
                    // $query->where([['name', 'module_spider']]);
                    $query->where([['name', 'module_spider'], ['object_value->module', strtolower($this->module)]]);
                }
            ]
        ]);
        return $this->view($return);
    }
    /**
     * OPEN /{prefix}/meta/{mid}
     * @param Request $request
     * @param $mid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_meta_item(Request $request, $mid)
    {
        $request->merge(['mid' => $mid]);
        return $this->view_index($request);
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.meta') ? $this->prefix . '.meta' : '_view.meta',
        ], $request->input('$return', []), );
        $return = array_merge($this->view_index($request)->getData(), $return);
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }

    public function view_meta_item_form(Request $request, $mid = 0)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.meta-form') ? $this->prefix . '.meta-form' : '_view.meta-form',
        ], $request->input('$return', []), );
        if ($request->method() === "GET") {
            $return['meta'] = $this->getReturn($this->select_meta_item(new Request(['mid' => $mid])));
        } elseif ($request->method() === "POST") {
            $return['meta'] = $this->getReturn($this->upsert_meta_item($request));
        }
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }

    /**
     * OPEN /{prefix}/content/{cid}
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_content_item(Request $request, $cid = 0)
    {
        $_logs = [__METHOD__, ['$request->all()', $request->all()], $cid];

        $request->merge(['cid' => $cid]);
        $return = [
            'view' => $request->input('$view', 'content-item'),
        ];
        if ($request->method() == 'POST') {
            // var_dump($request->method());
            $return['updated'] = $this->update_item($request, 'content');
            // switch ($request->input('action')) {
            //     case "insert":
            //     case "delete":
            //     case "update":
            //     case "upsert":
            //     case "select":
            //         break;
            //     default:
            //         break;
            // }
        }
        if ($cid == 0) {
            $return['content'] = new \App\Models\Content();
        } else {
            $return['content'] = $this->select_item($request, 'content');
            // $return['content'] = \App\Models\Content::with([
            //     'metas',
            //     'fields',
            //     'links',
            //     'comments'
            // ]);
            // if (!in_array($this->module, ['Home', 'Admin'])) {
            //     $return['content'] = $return['content']->whereHas("fields", function ($query) {
            //         $query->where([['name', 'module_' . strtolower($this->module)]]);

            //     });
            // }
            // $return['content'] = $return['content']->find($cid);
            // $return['module_field'] = $return['content']['fields'][0]->toArray();
        }
        // var_dump($return['content']);
        // var_dump($return['content']['fields']);
        // var_dump($return);
        if (empty($return['content']))
            abort(404, 'Null Value');
        // var_dump($return);
        $return['content'] = $return['content']->toArray();
        // $return['fields'] = $return['content']['fields'];
        return $this->view($return);

        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.content') ? $this->prefix . '.content' : '_view.content',
        ], $request->input('$return', []), );
        if ((int) $cid === 0) {
            // 发现
            if (request()->filled('source') && request()->filled('url')) {
                array_push($_logs, "requset filled source and url");
                $source = (new SpiderController)->select_content_item(new Request(['cid' => request()->input('source')]));
                $return['source'] = $source;
                $content = $this->select_content_item(new Request(['slug' => request()->input('url')]));
                $spider = new PhpSpiderHelper;
                $url = $spider->fill_url(request()->input('url'), $source['slug']);
                $fields = $source->get_source_fields($source->text['detail'] ?? [], [], ["{{url}}" => $url]);
                // dump($fields);
                $return['fields'] = $fields;
                $return['config_fields'] = $fields;
                $spider::$configs['fields'] = $fields;
                // $spider = new PhpSpiderHelper(["fields" => $fields]);
                $fields = $spider->unit($url);
                $return['extracted_fields'] = $fields;
                // dump($fields);
                // exit;
                $content = $content->fill($fields['content'] ?? [])->toArray();
                if (sizeof($this->ContentModel::$fields) > 0) {
                    foreach (array_keys($this->ContentModel::$fields) as $field_key) {
                        $content[$field_key] = $fields['content'][$field_key] ?? [];
                    }
                }
                $fields['content'] = $content;
                // dump($fields);
                $return = array_merge($return, $fields, $this->import_tree(new Request((array) $fields, ["status" => $source['status']])));
                // exit;
            } else if ($request->has('random')) {
                $return['content'] = $this->getReturn($this->select_random_content_item(new Request(['status' => 'publish'])));
                $return['content']['_random'] = true;
                // var_dump($return);
                // var_dump($return);
            }
        } else {
            $request->merge(['cid' => $cid]);
            // $return = array_merge($this->view_index($request)->getData(), $return);
            // unset($return['current_page'], $return['last_page']);
        }
        $return["_logs"] = $_logs;
        $request->merge(['$return' => $return]);
        return $this->view_index($request);
        // dump($return);
        // exit;
        // echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }
    /**
     * Summary of view_content_item_form
     * @param \Illuminate\Http\Request $request
     * @param mixed $cid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_content_item_form(Request $request, $cid = 0)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.content-item-form') ? $this->prefix . '.content-item-form' : '_view.content-item-form',
        ], $request->input('$return', []), );
        if ((int) $cid === 0) {
            $return['content'] = new $this->ContentModel(['parent' => null]);
        }
        // $return['options'] = $this->get_view_options(new Request(['names' => [
        //   'content.form.default',
        //   'content.form.' . $this->prefix,
        //   'content.type.default',
        //   'content.type.' . $this->prefix,
        //   'content.type.options.default',
        //   'content.type.options.' . $this->prefix,
        //   'content.status.default',
        //   'content.status.' . $this->prefix,
        //   'content.status.options.default',
        //   'content.status.options.' . $this->prefix,
        //   'content.text.default',
        //   'content.text.' . $this->prefix,
        // ]]));
        $return['options'] = [
            'content.form.default' => config('options.content.form.default'),
            'content.form.' . $this->prefix => config('options.content.form.' . $this->prefix),
            'content.type.default' => config('options.content.type.default'),
            'content.type.' . $this->prefix => config('options.content.type.' . $this->prefix),
            'content.type.options.default' => config('options.content.type.options.default'),
            'content.type.options.' . $this->prefix => config('options.content.type.options.' . $this->prefix),
            'content.status.default' => config('options.content.status.default'),
            'content.status.' . $this->prefix => config('options.content.status.' . $this->prefix),
            'content.status.options.default' => config('options.content.status.options.default'),
            'content.status.options.' . $this->prefix => config('options.content.status.options.' . $this->prefix),
            'content.text.default' => config('options.content.text.default'),
            'content.text.' . $this->prefix => config('options.content.text.' . $this->prefix),
        ];
        $request->merge(['$return' => $return, 'cid' => $cid]);
        return $this->view_index($request);
    }
    /**
     * Summary of view_content_list
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_content_list(Request $request)
    {
        try {

            $return = [
                'view' => $request->input('$view', 'content-list'),
                'contents' => $this->select_list($request, 'content'),
            ];

            return $this->view($return);
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
    /**
     * Summary of view_content_list_form
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_content_list_form(Request $request)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.content-list-form') ? $this->prefix . '.content-list-form' : '_view.content-list-form',
        ], $request->input('$return', []), );
        $request->merge(['$return' => $return]);
        return $this->view_index($request);
    }
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $cid
     * @param mixed $field_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_field_item(Request $request, $cid, $field_name)
    {
        $request->merge(['cid' => $cid, 'field_name' => $field_name]);
        $return = [
            'view' => $request->input('$view', 'field-item'),
            'field' => $this->select_item($request, 'field'),
        ];
        return $this->view($return);
        // $return = array_merge([
        //     "prefix" => $this->prefix ?? 'home',
        //     "view" => \View::exists($this->prefix . '.' . $field) ? $this->prefix . '.' . $field : '_view.' . $field,
        // ], $request->input('$return', []), );
        // if (request()->filled('source') && request()->filled('url')) {
        //     $source = (new SpiderController)->select_content_item(new Request(['cid' => request()->input('source')]));
        //     $return['source'] = $source;
        //     $field = $source->text[$field] ?? [];
        //     $spider = new PhpSpiderHelper;
        //     $url = $spider->fill_url(request()->input('url'), $source['slug']);

        //     $fields = $source->get_source_fields($field, [], ["{{url}}" => $url]);

        //     $spider = new PhpSpiderHelper(["fields" => $fields]);

        //     $fields = $spider->unit($url);
        //     $return['extracted_fields'] = $fields;
        //     $return = array_merge($return, $fields, $this->import_tree(new Request((array) $fields)) ?? []);
        // } else {
        // }
        // $return['latest_contents'] = $this->get_view_latest_contents(new Request());
        // $return['toplist_contents'] = $this->get_view_latest_contents(new Request());
        // // var_dump($return);
        // echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        // return $this->view($return['view'], $return);
    }


    /**
     * OPEN /{prefix}/discover/{cid}
     *
     * @param Request $request
     * @return void
     */
    public function view_spider_discover_list(Request $request)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.discover') ? $this->prefix . '.discover' : '_view.discover',
        ], $request->input('$return', []), );
        $return['sources'] = (new SpiderController)->select_content_list(new Request(['$where' => [], 'type' => "post_" . $this->prefix]));
        return $this->view($return['view'], $return);
    }

    public function view_spider_search_list(Request $request)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.list') ? $this->prefix . '.list' : '_view.list',
        ], $request->input('$return', []), );
        $sources = (new SpiderController)->select_content_list(new Request(['$where' => [], 'type' => "post_" . $this->prefix]));
        $return['sources'] = [];
        foreach ($sources as $index => $source) {
            // var_dump($source);
            $search = $source['text']['search'] ?? null;
            if (empty($search))
                continue;
            // var_dump($search);
            $fields = $source->get_source_fields($search, ['url', '_url', 'urls', '_urls', 'groups', '_groups']);
            if (empty($fields))
                continue;
            // var_dump($fields);
            $spider = new PhpSpiderHelper(["fields" => $fields]);
            $url = $spider->fill_url($search['url'], $source['slug']);
            $url = str_replace(['{{search}}'], [$request->input('search', '')], (string) $url);
            // dump($url);
            $fields = $spider->unit($url);
            // dump($fields);
            // $sources[] = array_merge($source->toArray(), $fields, $this->import_tree(new Request((array)$fields)) ?? []);
            array_push($return['sources'], array_merge($source->toArray(), $fields, $this->import_tree(new Request((array) $fields)) ?? []));
        }
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }

    /**
     *
     * @param Request $request
     * @return void
     */
    public function view_spider_discover_item(Request $request, $spider_cid, $discover_index = 0)
    {
        // dump(__METHOD__);
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.index') ? $this->prefix . '.index' : '_view.index',
            "current_page" => request()->input('page', '1'),
            "discover_index" => $discover_index,
            "last_page" => 1,
        ], $request->input('$return', []), );
        $source = (new SpiderController)->select_content_item(new Request(['cid' => $spider_cid]));
        $source->get_source_discover_urls();
        $return['source'] = $source;
        $discover = $source->text['discover'];
        $return['discover'] = $discover;
        $fields = $source->get_source_fields($discover, ['url', '_url', 'urls', '_urls', 'groups', '_groups', "_view"]);
        // var_dump($fields);
        // dump($fields,);

        $spider = new PhpSpiderHelper(["fields" => $fields]);
        $url = $source->get_source_discover_url($discover_index);
        $url = $spider->fill_url($url, $source['slug']);
        $url = str_replace('{{page}}', $return['current_page'], (string) $url);
        $fields = $spider->unit($url);
        // var_dump($fields);
        // exit;
        $fields['collection'] = [
            "name" => $source['title'],
            "description" => explode("::", $discover['urls'][$discover_index])[0],
            "slug" => $url,
            "ico" => $source['ico'],
            'type' => "collection",
            'status' => $source['status']
        ];
        // $result = $this->import_tree(new Request((array)$fields)) ?? [];
        // if ($result instanceof Exception) throw $result;

        // $collection = $this->import_tree(new Request(["meta" => $collection]));
        // dump($fields, $collection);
        // $contents = $source->unit();
        // dump($fields);
        $return = array_merge($return, $fields, $this->import_tree(new Request((array) $fields ?? []), ["type" => "post", "status" => $source['status']]));
        if ($return instanceof Exception)
            throw $return;
        // var_dump($return);
        // var_dump($return['contents']);
        $relationships = array_map(function ($content) use ($return) {
            return [
                $this->prefix . "_mid" => $return['collection']['mid'],
                $this->prefix . "_cid" => $content['cid'],
            ];
        }, $return['contents'] ?? []);
        // dump($relationships);
        if ($return['current_page'] == 1) {
            $this->RelationshipModel::where($this->prefix . "_mid", $return['collection']['mid'])->delete();
            $this->import_tree(new Request(["relationships" => $relationships]));
        }
        // $return = array_merge($return, []);
        // $return = array_merge($return, $fields);
        // $paginator = new Paginator($contents['data'] ?? [], 999, 1, []);
        // dump($paginator);
        // return $this->view('video.list', [
        //   "spider" => $spider,
        //   "discover_index" => $discover_index,
        //   "contents" => $paginator,
        // ]);
        // dump($return);
        $request->merge(['$return' => $return]);
        return $this->view_index($request);
        // <!-- echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>"; -->
        // return $this->view($return['view'], $return);
    }
    public function view_options(Request $request)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.options') ? $this->prefix . '.options' : '_view.options',
        ], $request->input('$return', []), );
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }

    /**
     * OPEN /{prefix}/404
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_404(Request $request)
    {
        $return = array_merge([
            "prefix" => $this->prefix ?? 'home',
            "view" => \View::exists($this->prefix . '.404') ? $this->prefix . '.404' : '_view.404',
        ], $request->input('$return', []), );
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return $this->view($return['view'], $return);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_exists(Request $request)
    {
    }

    /**
     * OPEN /{prefix}/tree/{slug}
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view_tree(Request $request)
    {
    }
}
