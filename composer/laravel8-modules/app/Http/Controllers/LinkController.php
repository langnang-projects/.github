<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
class LinkController extends Controller
{

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $return = [
            'links' => $this->getModel('link')::with(['children'])
                ->whereNull('deleted_at')
                ->get()
        ];
        return $this->view('link-form', $return);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validateLink($request);
        //
        $request->merge(['user' => \Auth::id()]);

        $link = new $this->getModel('link');
        $link->fill($request->all());
        $link->save();

        // return $this->edit($link->id);

        return redirect(($this->moduleAlias ?? 'home') . '/update-link/' . $link->id);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $return = [
            'link' => $this->getModel('link')::find($id),
        ];
        return $this->view('link', $return);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $return = [
            'link' => $this->getModel('link')::find($id),
            'links' => $this->getModel('link')::with(['children'])
                ->whereIn('type', ['template',])
                ->whereKeyNot($id)
                ->whereNull('deleted_at')
                ->get()
        ];
        return $this->view('link-form', $return);
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
        $this->validateLink($request);
        $request->merge(['user' => \Auth::id()]);
        $link = $this->getModel('link')::find($id);
        $link->fill($request->all());
        $link->save();

        return $this->edit($link->id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $link = $this->getModel('link')::find($id);
        $link->timestamps = false;
        $link->update([
            'deleted_at' => now()
        ]);

        \App\Models\Relationship::where('link_id', request()->input('id'))->delete();

        return redirect(($this->moduleAlias ?? 'home'));
        // return $this->view('index');

    }

    protected function validateLink(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'url' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
        ]);
    }
}
