<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Home\Models\HomeContent;

class HomeController extends \App\Http\Controllers\Controller
{
  use ViewTrait;
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view('home::index');
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('home::create');
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
    return view('home::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('home::edit');
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

trait ViewTrait
{
  public function view_index(Request $request)
  {
    $return = ['view' => 'index'];
    dump($return);
    return $this->view($return);
  }
  public function view_contents(Request $request)
  {
    $return = ['view' => 'contents', 'paginator' => HomeContent::paginate(15)];
    return $this->view($return);
  }
}
