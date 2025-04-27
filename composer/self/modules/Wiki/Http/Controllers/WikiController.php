<?php

namespace Modules\Wiki\Http\Controllers;

class WikiController extends \Illuminate\Controller\Controller
{
  public $alias = 'wiki';
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view($this->alias . '::index', [
      'title' => "Wiki",
      "illuminates" => app()->get_aliases(),
      "modules" => module()
      // "modules"=>
    ]);
  }

  public function filetree() {}
}
