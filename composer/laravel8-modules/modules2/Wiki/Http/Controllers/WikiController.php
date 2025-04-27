<?php

namespace Modules\Wiki\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class WikiController extends \App\Http\Controllers\Controller
{
    public function view_index($idOrSlug = null)
    {
        $return = [
            'contents' => [
                'paginator' => \App\Models\Content::factory()->times(15)->make(),
                'hottest' => \App\Models\Content::factory()->times(10)->make(),
            ],
            'metas' => [
                'categories' => \App\Models\Meta::factory()->times(10)->make(),
                'tags' => \App\Models\Meta::factory()->times(10)->make(),
                'groups' => \App\Models\Meta::factory()->times(10)->make(),
                'collections' => \App\Models\Meta::factory()->times(10)->make(),
            ],
            'comments' => [
                'latest' => \App\Models\Comment::factory()->times(10)->make(),
            ],
            'children' => $this->config('hasChildren') ? \App\Models\Meta::factory()->times(10)->make() : null,
        ];

        return $this->view('index', $return);
    }
}
