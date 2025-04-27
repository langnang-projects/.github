<?php

namespace Modules\CheatSheet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class CheatSheetController extends \App\Http\Controllers\Controller
{
    protected $contentModel = \Modules\CheatSheet\Models\CheatSheet::class;
}
