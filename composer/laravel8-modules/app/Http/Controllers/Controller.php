<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class Controller extends \App\Illuminate\Routing\ModuleController
{
    /**
     * 与控制器关联的模型列表
     * @var array
     */
    protected $models = [
        'meta' => \App\Models\Meta::class,
        'content' => \App\Models\Content::class,
        'link' => \App\Models\Link::class,
        'file' => \App\Models\File::class,
        'relationship' => \App\Models\Relationship::class,
        'field' => \App\Models\Field::class,
        'comment' => \App\Models\Comment::class,
        'user' => \App\Models\User::class,
        'option' => \App\Models\Option::class,
        'log' => \App\Models\Log::class,
    ];
    /**
     * Summary of view
     * @param mixed $view
     * @param mixed $data
     * @param mixed $mergeData
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($view = null, $data = [], $mergeData = [])
    {
        \DB::enableQueryLog();

        $this->setMetaAttributes();

        $this->setContentAttributes();

        $this->setLinkAttributes();


        // // metas[type=category]
        // $this->setAttribute('categories', $this->select_meta_categories(request()));
        // // metas[type=tag]
        // $this->setAttribute('tags', $this->select_meta_tags(request()));
        // // metas[type=module]
        // $this->setAttribute('modules', $this->select_meta_modules(request()));
        // // contents[type=template]
        // $this->setAttribute('templates', $this->select_content_templates(request()));
        // // contents[type=page]
        // $this->setAttribute('pages', $this->select_content_pages(request()));
        // // links[type=site]
        // // 根据模块对应的 MetaID 
        // $this->setAttribute('links', $this->select_link_sites(request()));

        // $this->setAttribute('latest_posts', $this->select_content_latest_posts(request()));

        // $this->setAttribute('latest_comments', []);
        // var_dump(__METHOD__);
        // $metaRelations = $this->module->relationships()->get();
        // var_dump($metaRelations->toArray());

        // $links = $this->getModel('link')::get();

        // $sql = \Blade::render('SELECT meta_id, cheatsheet_id  FROM `relationships`', $data);
        // $links = \App\Models\Link::with(['relationships'])->limit(1)->toSql();
        // var_dump($links->toArray());
        $return = array_merge($data, [
            // contents[type=post]
            'posts' => \Arr::get($data, 'posts', []),
        ]);


        if (empty($return['posts'])) {
            $query = $this->getModel('content')::with(['belongsToMeta', 'user'])->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getAttribute('id'));
            });
            if (request()->filled('title')) {
                $query = $query->where('title', 'like', '%' . request()->input('title') . '%');
            }
            $query = $query->where('type', 'post');
            $query = $query->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish']);
            $query = $query->whereNull('deleted_at');
            $query = $query->orderByDesc('updated_at');
            $query = $query->paginate();
            $return['posts'] = $query;
            unset($query);
        }

        return parent::view($view, $return, $mergeData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view('index');
    }
    public function welcome()
    {
        return $this->view('welcome', [
            'categories' => [],
            'tags' => [],
            'contents' => [],
            'latest_comments' => [],
            'latest_contents' => [],
            'links' => [],
        ]);
    }
    protected function setMetaAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.meta_attributes', 60 * 60 * 24, function () {
            return [
                'categories' => $this->select_meta_categories(request()),
                'tags' => $this->select_meta_tags(request()),
                'modules' => $this->select_meta_modules(request()),
            ];

        });
        $this->setAttributes($return);
    }
    protected function setContentAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.content_attributes', 60 * 60, function () {
            return [
                'templates' => $this->select_content_templates(request()),
                'pages' => $this->select_content_pages(request()),
                'latest_posts' => $this->select_content_latest_posts(request()),
                'latest_comments' => [],
            ];

        });
        $this->setAttributes($return);
    }
    protected function setLinkAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.link_attributes', 60 * 60 * 24, function () {
            return [
                'links' => $this->select_link_sites(request()),
            ];

        });
        $this->setAttributes($return);
    }
    /**
     * Summary of getMetaModules
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_modules(Request $request)
    {

        $query = $this->getModel('meta')::with([
            'children' => function ($query) {
                $query->where('type', 'module');
            },
            'relationships'
        ])->where('type', 'module')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->where('parent', 0)
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        $this->setAttributeSql('select_meta_modules');
        return $query;
    }
    /**
     * Summary of getMetaCategories
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_categories(Request $request)
    {
        $query = $this->getModel('meta')::with(['children'])
            ->where('parent', $this->getAttribute('id'))
            ->where('type', 'category')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        $this->setAttributeSql('select_meta_categories');
        return $query;
    }
    /**
     * Summary of getMetaTags
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_tags(Request $request)
    {
        $query = $this->getModel('meta')::with([])
            ->where('type', 'tag')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->where('parent', $this->getAttribute('id'))
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        $this->setAttributeSql('select_meta_tags');
        return $query;
    }


    protected function select_content_latest_posts(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getAttribute('id'));
            })
            ->where('type', 'post')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        $this->setAttributeSql('select_content_latest_posts');
        return $query;
    }
    protected function select_content_templates(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getAttribute('id'));
            })
            ->where('type', 'template')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        $this->setAttributeSql('select_content_latest_posts');
        return $query;
    }
    protected function select_content_pages(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getAttribute('id'));
            })
            ->where('type', 'page')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        $this->setAttributeSql('select_content_latest_posts');
        return $query;
    }

    /**
     * 查询 模块Meta 关联的Link[type=site]
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function select_link_sites(Request $request)
    {
        $query = $this->getModel('link')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getAttribute('id'));
            })
            ->where('type', 'site')
            ->whereIn('type', ['site'])
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->where('title', '!=', '')
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get();
        $this->setAttributeSql('select_link_sites');
        return $query;
    }


}
