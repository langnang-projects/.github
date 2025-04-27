<?php

namespace Modules\CheatSheet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class CheatSheetLinkController extends \App\Http\Controllers\LinkController
{
    protected $contentModel = \Modules\CheatSheet\Models\CheatSheet::class;
}
