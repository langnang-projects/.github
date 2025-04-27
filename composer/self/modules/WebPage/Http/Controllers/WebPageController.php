<?php

namespace Modules\WebPage\Http\Controllers;

use Illuminate\Http\Request;

class WebPageController extends \Illuminate\Controller\Controller
{
  /**
   * @return void
   */
  /**
   * Display a listing of the resource.
   * @return object|\Core\Illuminate
   */
  public function index()
  {
    $contents = \DB::select('webpage_contents');
    // dump($contents);
    return view('webpage::index', [
      'title' => "WebPage",
      'contents' => $contents,
      // "modules"=>
    ]);
  }

  /**
   * Summary of content
   * @param \Illuminate\Http\Request $request
   * @param mixed $cid
   * @return object|\Core\Illuminate
   */
  public function content(Request $request, $cid)
  {
    // var_dump($request);
    // var_dump($cid);
    $content = \DB::select('webpage_contents', ["`cid` = $cid"]);
    if (empty($content)) return view(404);
    // var_dump($content);
    $content = $content[0];
    return view('webpage::content', [
      'title' => "WebPage",
      'content' => $content,
    ]);
  }
}
