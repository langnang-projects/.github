<?php

namespace Modules\CheatSheet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class CheatSheetMetaController extends \App\Http\Controllers\MetaController
{
    protected $contentModel = \Modules\CheatSheet\Models\CheatSheet::class;
}
