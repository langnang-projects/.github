<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class ContentController extends Controller
{
    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $content = $this->getModel('content')::with(['contents', 'links'])->find($id);
        if (empty($content))
            abort(404);
        $return = [
            'content' => $content,
        ];
        return $this->view('content', $return);
    }

}
