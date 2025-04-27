<?php

namespace Modules\WebSpider\Http\Controllers;

use Illuminate\Request\Request;

class WebSpiderController
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    $contents = \DB::table('_contents');
    // var_dump($contents);
    $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../../../storage/data/phpspider.json'), true);
    $contents = $configs['contents'];
    return view(config('this.alias') . '::index', [
      'configs' => $configs,
      "contents" => $contents,
    ]);
  }

  public function content(Request $request)
  {
    $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../../../storage/data/phpspider.json'), true);
    $contents = $configs['contents'];
    $content = $contents[$request->input('slug')];

    view(config('this.alias') . '::content', [
      'configs' => $configs,
      "contents" => $contents,
      "content" => $content,
    ]);
  }
  public function ob_spider(Request $request)
  {
    $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../../../storage/data/phpspider.json'), true);
    $contents = $configs['contents'];
    $content = $contents[$request->input('slug')];

    $config = $content;

    $config['db_config'] = [
      'host'  => env('DB_HOST') ?? '127.0.0.1',
      'port'  => env('DB_PORT') ?? 3306,
      'user'  => env('DB_USERNAME') ?? 'root',
      'pass'  => env('DB_PASSWORD') ?? 'root',
      'name'  => env('DB_DATABASE') ?? 'demo',
    ];
    $config['export'] = [
      'type' => 'db',
      'table' => "webspider_logs",
      'unique_column' => "url",
    ];
    $config['max_fields'] = 100;

    view(config('this.alias') . '::ob-spider', [
      'configs' => $configs,
      "contents" => $contents,
      "content" => $content,
      "config" => $config,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view(config('this.alias') . '::create');
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
    return view(config('this.alias') . '::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view(config('this.alias') . '::edit');
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
}
