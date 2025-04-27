<?php

namespace Modules\Manual\Http\Controllers;

use Illuminate\Request\Request;

class ManualController
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view('manual::index', [
      'title' => "Manual",
      "illuminates" => app()->get_aliases(),
      "modules" => module()
      // "modules"=>
    ]);
  }
  public function alias(Request $request, $alias, $file = 'index')
  {
    // dump($alias, $dir);
    $title = app($alias)->name;
    if (empty($title)) {
      app_log(__METHOD__ . " Error $title");
      return view('404');
    }
    // dump($dir);
    $path = base_path("illuminate" . DIRECTORY_SEPARATOR . "$title" . DIRECTORY_SEPARATOR . "index.md");
    if (!file_exists($path)) {
      app_log(__METHOD__ . " Error $path");
      return view('404');
    }
    // dump([$path]);
    $markdown = file_get_contents($path);
    // dump([$path, $markdown]);
    $html = \Markdown::make($markdown, []);
    // var_dump([$path, $markdown, $html]);
    return view('manual::alias', [
      "title" => $title,
      "markdown" => $markdown,
      "html" => $html,
    ]);
  }
  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('manual::create');
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
    return view('manual::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('manual::edit');
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
