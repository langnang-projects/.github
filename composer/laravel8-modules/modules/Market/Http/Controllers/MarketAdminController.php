<?php

namespace Modules\Market\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use App\Support\Module;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use wapmorgan\UnifiedArchive\UnifiedArchive;


class MarketAdminController extends \Modules\Admin\Http\Controllers\AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
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
    // function getStorageData($key = null)
    // {
    //     $return = json_decode(Storage::get('module/packages.json'), true);
    //     if (empty($key)) return $return;
    //     return Arr::get($return, $key);
    // }
    // function setStorageData()
    // {
    // }
    public function view_admin_index(Request $request, $return)
    {
        // $return = $request->all();
        $return['projects_installed'] = json_decode(app('files')->get('public\\vendor\\packages.lock'), true);
        $return['themes'] = array_filter(Http::get("http://api.github.com/repos/ln-laravel-modular/theme-packages/branches")->json(), function ($item) {
            return !in_array($item['name'], ['master', 'empty', 'develop']);
        });
        $return['examples'] = array_filter(Http::get("http://api.github.com/repos/ln-laravel-modular/example-packages/branches")->json(), function ($item) {
            return !in_array($item['name'], ['master', 'empty', 'develop']);
        });
        $return['modules'] = array_filter(Http::get("http://api.github.com/orgs/ln-laravel-modular/repos")->json(), function ($item) {
            return !in_array($item['name'], ['ln-laravel-modular', 'example-packages', 'theme-packages']);
        });
        if ($request->filled('from')) {
            $from = $request->input('from');
            Arr::set($return, 'http', []);
            $return['branch'] = $branch = Arr::get($return, "moduleConfig.branches." . $request->input('from'));
            if ($request->filled('name')) {
                $method = "request_version_list";
                $urlKey = "versions";
                $return['project_installed'] = $return['projects_installed'][$request->input('name')] ?? null;
            } else {
                $method = "request_project_list";
                $urlKey = "projects";
            }
            Arr::set($return, 'http.key', $method);
            Arr::set($return, 'http.url', $url = str_replace([
                "{{\$search}}",
                "{{\$name}}",
            ], [
                $request->input('search', 'bootstrap'),
                $request->input('name', ),
            ], Arr::get($branch, $method . '.url', '')));
            if (!empty($url))
                Arr::set($return, 'http.response', $return[$urlKey] = Http::get(Arr::get($return, 'http.url'))->json());
            // $return[$urlKey] =
            // Arr::get(Arr::get($branch, $method . '.response_key', ''),);
            // var_dump($url);
            // var_dump(Arr::get($return, 'http.response'));
            if (isset($branch[$method]['response_key'])) {
                $return[$urlKey] = Arr::get(Arr::get($return, 'http.response'), Arr::get($branch, $method . '.response_key', ));
            }
            // var_dump($return[$urlKey]);
            switch (Arr::get($branch, $method . '.response_type', 'object')) {
                case 'array':
                    $return[$urlKey] = array_map(function ($item) use ($branch, $method) {
                        $res = [];
                        foreach (Arr::get($branch, $method . '.response_keys') ?? [] as $result_key => $response_key) {
                            // var_dump([$key, $response_key]);
                            if (empty($response_key))
                                continue;
                            $res[$result_key] = $item[$response_key];
                        }
                        return $res;
                    }, $return[$urlKey] ?? []);
                    break;
                case 'object':
                    $res = [];
                    foreach (Arr::get($branch, $method . '.response_keys') ?? [] as $result_key => $response_key) {
                        // var_dump([$key, $response_key]);
                        if (empty($response_key))
                            continue;
                        $res[$result_key] = $return[$urlKey][$response_key];
                    }
                    $return[$urlKey] = $res;
                    break;
                default:
                    break;
            }
        }


        return $this->view($return['view'], $return);
    }
    function view_index(Request $request)
    {
        $return = $request->all();
        $return['categories'] = $this->getOriginalData($this->select_meta_list(new Request(['type' => 'category'])));
        $return['meta'] = $this->getOriginalData($this->select_meta_item(new Request(['slug' => $request->input('meta', 'tag-installed')])));
        $return['contents'] = $this->getOriginalData($this->select_content_list(new Request(['meta' => $request->input('meta', 'tag-installed')])));
        $return['modules'] = $this->getOriginalData($this->select_module_list(new Request()));
        $return['installed'] = $this->getOriginalData($this->select_module_installed_list(new Request()));
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return view('admin.market.index', $return);
    }
    function view_slug(Request $request, $slug)
    {
        $return = $request->all();
        $return['slug'] = $slug;
        $return['categories'] = $this->getOriginalData($this->select_meta_list(new Request(['type' => 'category'])));
        $return['contents'] = $this->getOriginalData($this->select_content_list(new Request(['meta' => 'installed'])));
        $return['modules'] = json_decode(Storage::get('module/modules.json'), true);
        $return['module'] = $module = Arr::first($return['modules'], function ($item) use ($slug) {
            return $item['slug'] == $slug;
        }, );
        if (Storage::exists("module/modules.{$slug}.json")) {
            $return['data'] = json_decode(Storage::get("module/modules.{$slug}.json"), true);
        } else if (!empty($module['packages_url'])) {
            $url = str_replace(['{{key}}'], [$request->input('value', 'ui')], $module['packages_url']);
            $response = Http::get($url);
            $return['data'] = $response->json();
        }
        $return['installed'] = array_map(function ($item) {
            $args = explode(" | ", $item);
            return ['slug' => $args[0], 'versions' => [$args[1]], 'version_url' => $args[2]];
        }, array_filter(explode("\n", Storage::get('/module/.done'))));
        echo "<script>window.\$data=" . json_encode($return, JSON_UNESCAPED_UNICODE) . "</script>";
        return view('admin.market.index', $return);
    }
    function view_content_item(Request $request, $cid = 0)
    {
        $return = $request->all();
        return view('admin.market.content', $return);
    }
    public $package_path_prefix = "";
    public $module_path_prefix = "";
    public function install_pipline(Request $request)
    {
        $return = $request->all();
        $url = $return['url'];
        // $headers = curl_headers($url);
        $next = [
            'name' => $return['name'],
            'version' => $return['version'],
            'url' => $return['url'],
            'operate' => null,
            'byte_interval' => 1024 * 100,
        ];
        $pathinfo = pathinfo($return['url']);
        $basename = $pathinfo['basename'];
        $filename = $pathinfo['filename'];
        $successMsg = '';
        switch ($return['operate']) {
            case "start":
                $headers = curl_headers($url);

                Storage::append('module/.todo', $url);
                Storage::put("module/packages/{$filename}.progress", $url . ' | ' . ($headers['file_size'] ?? '-') . ' | 0');

                $next['header_size'] = $headers['file_size'] ?? null;
                $next['header_md5'] = $headers['file_md5'] ?? null;
                $next['operate'] = 'download';
                $next['byte_range'] = [null, -1];
                if (Storage::exists('module/packages/' . $pathinfo['basename'])) {
                    $return['file_size'] = Storage::size('module/packages/' . $pathinfo['basename']);
                    $return['file_progress'] = $return['file_size'] / $headers['file_size'];
                    $return['file_md5'] = md5_file(storage_path('app/module/packages/' . $pathinfo['basename']));
                    if ($return['file_size'] >= $next['header_size']) {
                        // $next['operate'] = 'unzip';
                        $next['operate'] = 'path';
                    }
                } else {
                    $return['file_size'] = 0;
                    $return['file_progress'] = 0;
                }
                $next['byte_range'] = [$return['file_size'], $return['file_size'] + $next['byte_interval'] - 1];
                $next['byte_range'][1] = $next['byte_range'][1] > $next['header_size'] ? $next['header_size'] - 1 : $next['byte_range'][1];
                break;
            case "pause":
                break;
            case "download":
                $next['header_size'] = $return['header_size'] ?? null;
                $next['header_md5'] = $return['header_md5'] ?? null;

                $progress = curl_download($url, implode("-", $return['byte_range']));
                // Storage::append 会自动添加换行符
                file_put_contents('storage/app/module/packages/' . $pathinfo['basename'], $progress['stream'], FILE_APPEND);
                // Storage::append('module/packages/' . $pathinfo['basename'], $progress['stream']);
                Storage::append("module/packages/{$filename}.progress", $url . ' | ' . ($return['header_size'] ?? '-') . ' | ' . implode("-", $return['byte_range']));

                $return['file_size'] = Storage::size('module/packages/' . $pathinfo['basename']);
                $return['file_progress'] = $return['file_size'] / $return['header_size'];
                $return['file_md5'] = md5_file(storage_path('app/module/packages/' . $pathinfo['basename']));
                if ($return['file_size'] < $return['header_size']) {
                    $next['operate'] = 'download';
                    $next['byte_range'] = [$return['file_size'], $return['file_size'] + $next['byte_interval'] - 1];
                    $next['byte_range'][1] = $next['byte_range'][1] > $next['header_size'] ? $next['header_size'] - 1 : $next['byte_range'][1];
                } else if (!is_null($return['header_md5']) && strlen($return['header_md5']) == strlen($return['file_md5']) && $return['header_md5'] == $return['file_md5']) {
                    $next['operate'] = 'path';
                } else {
                    // throw new Exception("error file md5.");
                }
                break;
            case "pause-download":
                $next['operate'] = 'finish';
                break;
            // 选择解压文件中指定路径
            case "path":
                $archive = UnifiedArchive::open(storage_path('app/module/packages/' . $pathinfo['basename']));
                // var_dump($archive->getFileNames());
                // var_dump($archive->getFiles('package/src/*'));
                // $files = $archive->getFiles();
                // while (sizeof($files) > 0) {
                //     foreach ($archive->getFiles() as $index => $file) {

                //     }

                // }
                $maxPathDepth = 0;
                $files = $archive->getFiles();
                foreach ($archive->getFiles() as $file) {
                    $exp = explode('/', $file);
                    if (sizeof($exp) > $maxPathDepth) {
                        $maxPathDepth = sizeof($exp);
                    }
                }
                // dump($maxPathDepth);
                for ($depth = $maxPathDepth; $depth > 0; $depth--) {
                    foreach ($files as $index => $file) {
                        // $file = is_string($file) ? $file : $index;
                        $exp = explode('/', is_string($file) ? $file : $index);
                        if (sizeof($exp) != $depth)
                            continue;
                        $pathinfo = pathinfo(is_string($file) ? $file : $index);
                        if (!isset($files[$pathinfo['dirname']])) {
                            $files[$pathinfo['dirname']] = array_merge(pathinfo($pathinfo['dirname']), [
                                'type' => "dir",
                                "children" => []
                            ]);
                        }
                        if (isset($pathinfo['extension'])) {
                            $pathinfo['type'] = 'file';
                        } else {
                            $pathinfo['type'] = 'dir';
                        }
                        // $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = array_merge($pathinfo, is_string($file) ? [] : $file);
                        $pathinfo = array_merge($pathinfo, is_string($file) ? [] : $file);

                        if ($pathinfo['type'] == 'file') {
                            array_push($files[$pathinfo['dirname']]['children'], $pathinfo);
                        } else {
                            array_unshift($files[$pathinfo['dirname']]['children'], $pathinfo);
                        }
                        unset($files[$index]);
                        // $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = $pathinfo;
                    }

                }

                // foreach ($archive->getFiles() as $file) {
                //     $pathinfo = pathinfo($file);
                //     if (!isset($files[$pathinfo['dirname']])) {
                //         $files[$pathinfo['dirname']] = [
                //             'filetype' => "dir",
                //             "children" => []
                //         ];
                //     }
                //     $files[$pathinfo['dirname']]['children'][$pathinfo['basename']] = $pathinfo;
                //     // array_push($files[$pathinfo['dirname']]['children'], $pathinfo);
                //     // var_dump(pathinfo($file));
                //     //     var_dump(pathinfo(pathinfo($file)['dirname']));

                // }
                // dump($files);
                $return['files'] = $files['.']['children'];
                break;
            case "unzip":
                $files = null;
                UnifiedArchive::open(storage_path('app/module/packages/' . $pathinfo['basename']))
                    ->extract(storage_path('app/module/packages/' . $pathinfo['filename']), $files);
                $next['operate'] = 'install';
                $next['files'] = $files;
                break;
            case "install":
                $return = $this->getOriginalData($this->install_pipline_of_copy($request));
                $next['operate'] = 'finish';
                break;
            case "uninstall":
                $next['operate'] = 'finish';
                break;
            default:
                break;
        }
        $return = array_merge($return, ['next' => $next]);
        return $this->response_success($return, $successMsg);
    }
    public function install_pipline_of_start(Request $request)
    {
    }
    public function install_pipline_of_pause()
    {
    }
    public function install_pipline_of_stop()
    {
    }
    public function install_pipline_of_download(Request $request)
    {
    }
    public function install_pipline_of_unzip(Request $request)
    {
        try {
            $return = $request->all();
            $url = $return['url'];
            $pathinfo = pathinfo($url);
            UnifiedArchive::open(storage_path('app/module/packages/' . $pathinfo['basename']))
                ->extract(storage_path('app/module/packages/' . $pathinfo['filename']));
            return $this->response_success($return);
        } catch (Exception $e) {
            return $this->response_error($e);
        }
    }
    public function install_pipline_of_copy(Request $request)
    {
        try {
            $return = $request->all();
            $url = $return['url'];
            $pathinfo = pathinfo($url);
            $return['toDirectory'] = 'public/vendor/' . $return['name'] . '/' . $return['version'];
            foreach ($return['files'] as $path) {
                app('files')->copyDirectory('storage/app/module/packages/' . $pathinfo['filename'] . '/' . $path, $return['toDirectory']);
            }
            return $this->response_success($return);
        } catch (Exception $e) {
            return $this->response_error($e);
        }
    }
    public function install_pipline_of_config(Request $request)
    {
        try {
            $return = $request->all();
            $url = $return['url'];
            $pathinfo = pathinfo($url);
            return $this->response_success($return);
        } catch (Exception $e) {
            return $this->response_error($e);
        }
    }
    function install_pipline_of_finish(Request $request)
    {
    }
    function select_meta_item(Request $request)
    {
        $return = $this->getStorageData("metas");
        if ($request->filled('slug')) {
            $return = Arr::first($return, function ($value, $key) use ($request) {
                return $value['slug'] == $request->input('slug');
            });
        }
        return $this->response_success($return);
    }
    function select_meta_list(Request $request)
    {
        $return = $this->getStorageData("metas");
        if ($request->filled('type')) {
            $return = Arr::where($return, function ($value, $key) use ($request) {
                return !empty($value['type']) && $value['type'] == $request->input('type');
            });
        }
        return $this->response_success($return);
    }
    function select_content_list(Request $request)
    {
        $return = $this->getStorageData("contents");
        if ($request->filled('type')) {
            $return = Arr::where($return, function ($item, $key) use ($request) {
                return !empty($item['type']) && $item['type'] == $request->input('type');
            });
        }
        if ($request->filled('meta')) {
            $return = Arr::where($return, function ($item, $key) use ($request) {
                return !empty($item['metas']) && in_array($request->input('meta'), $item['metas']);
            });
        }
        return $this->response_success($return);
    }
    function select_module_list(Request $request)
    {
        $return = json_decode(Storage::get('module/modules.json'), true);
        return $this->response_success($return);
    }
    function select_module_installed_list(Request $request)
    {
        $return = array_map(function ($item) {
            $args = explode(" | ", $item);
            return ['slug' => $args[0], 'versions' => [$args[1]], 'version_url' => $args[2]];
        }, array_filter(explode("\n", Storage::get('/module/.done'))));
        return $this->response_success($return);
    }
    function select_package_list(Request $request)
    {
    }
}
