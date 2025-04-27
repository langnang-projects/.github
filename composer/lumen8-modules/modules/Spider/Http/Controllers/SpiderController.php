<?php

namespace Modules\Spider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Modules\Spider\Models\SpiderContentModel;
use Modules\Spider\Supports\phpspider\phpspider;

class SpiderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('spider::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('spider::create');
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
        return view('spider::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('spider::edit');
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

    public function start(Request $request, $slug)
    {
        $text = config('spider.contents.1.text');

        $text_config = substr($text, strripos($text, "```ini"));
        $ini = parse_ini_string($text_config, true, INI_SCANNER_RAW);

        $configs = $ini['spider'];

        $configs['export'] = [
            'type' => 'csv',
            'file' => './data/' . ($configs['slug'] ?? $configs['name']) . '.csv', // data目录下
        ];


        $configs['fields'] = array_map(function ($name, $index) use ($configs) {
            return [
                'name' => $name,
                'selector' => $configs['fields.selector'][$index],
                'required' => $configs['fields.required'][$index],
                'repeated' => $configs['fields.repeated'][$index],
                'default' => $configs['fields.default'][$index],
                'filters' => $configs['fields.filters'][$index] ?? '',
            ];
        }, $configs['fields.name'], array_keys($configs['fields.name']));

        var_dump($configs);

        $configs['max_fields'] = 5;
        // foreach ($configs['fields.name'] as $index => $name) {
        //     var_dump($index);
        //     var_dump($name);
        // }

        $spider = new phpspider($configs);


        $spider->on_download_page = function ($page, $phpspider) {
            var_dump($page['url']);
            return $page;
        };

        $spider->on_extract_page = function ($page, $data) {
            var_dump($data);
            return $data;
        };
        $spider->start();
    }

    public function test(Request $request)
    {
        // $paginator = SpiderContentModel::paginate();
        // var_dump($paginator);
        $item = SpiderContentModel::with(['metas'])->where('cid', 23)->first()->toArray();
        var_dump($item);
        var_dump($item['ini']['spider']);
    }
}
