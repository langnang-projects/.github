<?php

namespace Modules\WebPage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class WebPageContentController extends \App\Http\Controllers\ContentController
{
    protected $contentModel = \Modules\WebPage\Models\WebPage::class;
}
