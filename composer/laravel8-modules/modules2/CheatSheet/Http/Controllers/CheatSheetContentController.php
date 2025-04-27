<?php

namespace Modules\CheatSheet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class CheatSheetContentController extends \App\Http\Controllers\ContentController
{
    protected $contentModel = \Modules\CheatSheet\Models\CheatSheet::class;
}
