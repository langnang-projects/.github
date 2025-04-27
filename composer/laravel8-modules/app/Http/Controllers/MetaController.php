<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class MetaController extends Controller
{



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $return = [
            'meta' => $this->getModel('meta')::find($id),
        ];
        return $this->view('meta', $return);
    }


}
