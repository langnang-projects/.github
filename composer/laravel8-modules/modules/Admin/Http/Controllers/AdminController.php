<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Universal management controller
 * 通用管理控制器
 * @method mixed index(\Illuminate\Http\Request $request)
 * @method mixed create()
 * @method mixed factory()
 * @method mixed store()
 * @method mixed edit()
 * @method mixed update()
 * @method mixed destory()
 * @method mixed import()
 * @method mixed export()
 * @method mixed list()
 * @method mixed move()
 * @method mixed copy()
 * @method mixed validate()
 */
class AdminController extends \App\Illuminate\Routing\ModuleController
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
    protected function setName($value = null, $pattern = null)
    {
        if (!empty($value))
            $this->name = \Str::studly($value);

        if (empty($pattern))
            $pattern = '/^Modules\\\\(\w*)\\\\Http/i';

        // $this->middleware('auth');
        if (empty($this->name)) {
            if (preg_match('/^admin\/modules\/(\w*)/i', request()->path(), $matches)) {
                $this->name = $matches[1];
            } else {
                $this->name = 'Home';
            }
        }
        $this->setAttribute('name', $this->name);
        $this->alias = \Str::lower($this->name);
        $this->setAttribute('alias', $this->alias);
    }

    protected $childModuleController;
    /**
     * Module:Admin 对应的控制器
     * @var 
     */
    protected $admin;
    public function __construct($moduleName = null)
    {
        $this->setName($moduleName, );
        $this->setModule($moduleName);
        $this->initAttributes();
        // 
        // $this->childModuleController = new \App\Http\Controllers\Controller('Home');
        $this->admin = new \App\Http\Controllers\Controller('Admin');
    }

    /**
     * Summary of matchView
     * @param mixed $data
     * @return mixed
     */
    protected function matchView($data)
    {

        if (!isset($data['view']))
            abort(403);

        if (empty($data['layout'])) {
            $data['layout'] = 'admin::' . $this->getConfig('view.framework', ) . '.' . $data['view'];
            // var_dump($return['layout']);
            if (!View::exists($data['layout'])) {
                $return['layout'] = $data['view'];
            }
            // var_dump($return['layout']);
            $data['view'] = $this->alias . '::' . $this->getConfig('view.framework') . '.' . $data['view'];
            // var_dump($return['view']);
        }
        if (!View::exists($data['view'])) {
            $data['view'] = $data['layout'];
        }
        return $data;
    }

    protected function view($view = null, $data = [], $mergeData = [])
    {
        $return = array_merge($data, [
            'view' => $view,
            'admin' => array_merge($this->admin->getAttribute() ?? [], [
                'categories' => \Arr::get($data, 'admin.categories', $this->select_admin_meta_categories()),
                'active_category' => \Arr::get($data, 'admin.active_category', $this->select_admin_active_category()),
            ]),
            'modules' => \Arr::get(
                $data,
                'modules',
                \Cache::remember("meta_modules", 24 * 3600, function () {
                    $query = $this->getModel('meta')::with([
                        'children' => function ($query) {
                            $query->with(['children'])->where('type', 'module');
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
                }),
            ),
            // 'childModule' => $this->childModuleController->getModuleAttributes(),
        ]);
        if (empty(\Arr::get($return, 'admin.active_category'))) {
            // abort(404);
        }
        $return = $this->matchView($return);

        return parent::view($return['view'], $return, $mergeData);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        return $this->view('index');
    }
    /**
     * 查询 Meta 表中 Module:Admin 下 type=category 的树形数据
     * @return mixed
     */
    protected function select_admin_meta_categories()
    {
        // return \Cache::remember('admin_module.meta_categories', 24 * 3600, function () {
        return $this->getModel('meta')::with([
            'children' => function ($query) {
                return $query->orderBy('order');
            }
        ])
            ->where('type', 'category')
            ->whereIn('status', ['public', 'publish',])
            ->where('parent', $this->admin->getAttribute('id'))
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->orderBy('order')
            ->get();
        // });
    }
    /**
     * 根据当前路径 slug 查询对应 Meta 表中数据
     * @return mixed
     */
    protected function select_admin_active_category()
    {
        return $this->getModel('meta')::with(['parent'])
            ->where('slug', \Str::replace('/', ':', request()->path()))
            ->first();
    }
}

