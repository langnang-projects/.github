<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Redirect;

class AdminMetaController extends AdminController
{
    /**
     * Display a paging list of the resource.
     * 显示资源的分页列表
     * @param \Illuminate\Http\Request $request
     * @done 统计子类数量
     * @done 若存在 slug ，就模糊查询
     * @done 若存在 name ，就模糊查询
     * @return Renderable
     */
    public function index(Request $request)
    {

        // if ($request->method() == 'POST')
        // $this->import($request->merge(['meta_id' => $request->input('parent', 0)]));

        $query = $this->getModel('meta')::withCount('children');

        $request->whenFilled('slug', function ($input) use (&$query) {
            $query = $query->where('slug', 'like', "%$input%");
        });
        $request->whenFilled('name', function ($input) use (&$query) {
            $query = $query->where('name', 'like', "%$input%");
        });
        $query = $query
            ->whereIn('type', $request->filled('type') ? [$request->input('type')] : array_keys($this->getOption('meta.type', [])))
            ->whereIn('status', $request->filled('status') ? [$request->input('status')] : array_keys($this->getOption('meta.status', [])))
            ->where('parent', $request->input('parent', 0))
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->orderByDesc('updated_at');
        $this->setAttributeSql('select_meta_list', $query->toRawSql());
        return $this->view('ssential.meta-table', [
            'paginator' => $query->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 显示用于创建新资源的表单
     * @param \Illuminate\Http\Request $request
     * @done 根据请求中数据创建新资源
     * @return Renderable
     */
    public function create()
    {
        $model = $this->getModel('meta');
        $return = [
            'item' => new $model(request()->all()),
        ];
        return $this->view('ssential.meta-form', $return);
    }
    /**
     * Show the form for creating a new resource that has been populated with factory
     * 显示用于创建已用模型工厂填充的新资源的表单
     * @param \Illuminate\Http\Request $request
     * @done 使用模型工厂创建新资源
     * @done 根据请求中数据替换新资源中对应数据
     * @return Renderable
     */
    public function factory(Request $request)
    {
        $num = $request->input('num', 1);
        $model = $this->getModel('meta');
        // 2025-01-09 14:15:42 使用模型工厂创建新资源
        $return = [
            'item' => \Arr::first($model::factory(1)->make()),
        ];
        // 2025-01-09 14:15:31 重置或替换为 Request 中数据
        $return['item']['parent'] = $request->input('parent', 0);
        $return['item']['count'] = $request->input('count', 0);
        $return['item']['order'] = $request->input('order', 0);
        return $this->view('ssential.meta-form', $return);
    }

    /**
     * Store a newly created resource in storage.
     * 将新创建的资源存储在存储器中。
     * @param Request $request
     * @done 2025-01-09 10:10:17 验证表单
     * @done 2025-01-09 10:10:17 绑定用户
     * @done 2025-01-09 10:10:17 重定向
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 验证表单
        $this->validata_item($request);
        // 绑定用户
        $request->merge(['user_id' => \Auth::id()]);

        $model = $this->getModel('meta');

        $meta = new $model($request->all());
        // $meta->fill($request->all());
        // $parent = $model::find($meta->parent);
        // if ($parent) {

        // }
        // 保存资源
        $meta->save();
        // 清除缓存
        if (in_array($meta->type, ['module'])) {
            \Cache::forget("meta_modules");
        }
        // 重定向至编辑页面
        return redirect(str_replace(['create', 'factory'], $meta->id, $request->path()));
        // return redirect(($this->moduleAlias ?? 'home') . '/update-content/' . $meta->id);
        // return $this->edit($meta->id);

        // return redirect(($this->moduleAlias ?? 'home') . '/update-meta/' . $meta->id)->withInput($meta->toArray());

    }
    /**
     * Show the form for editing the specified resource.
     * 显示用于编辑指定资源的表单。
     * @param int|string $ids
     * @done 根据 ID 查询对应资源
     * @return Renderable
     */
    public function edit($id)
    {
        $item = $this->getModel('meta')::with(['relationships'])->find($id);
        if ($item['type'] == 'module') {
            $item['modules'] = $this->getModel('meta')::with(['children'])
                ->where('type', 'module')
                ->where('parent', $item->id)
                ->get();
            $item['branches'] = $this->getModel('meta')::with([])
                ->where('type', 'branch')
                ->where('parent', $item->id)
                ->get();
            $item['categories'] = $this->getModel('meta')::with(['children'])
                ->where('type', 'category')
                ->where('parent', $item->id)
                ->get();
            $item['tags'] = $this->getModel('meta')::with([])
                ->where('type', 'tag')
                ->where('parent', $item->id)
                ->get();
        }


        $return = [
            'item' => $item,
        ];
        return $this->view('ssential.meta-form', $return);
    }

    /**
     * Update the specified resource in storage.
     * 更新存储中的指定资源。
     * @param Request $request
     * @param int $id
     * @done 根据 ID 查询对应资源
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // 验证表单
        $this->validata_item($request);

        // 绑定用户
        $request->merge(['user_id' => \Auth::id()]);
        // 
        $meta = $this->getModel('meta')::find($id);
        // 
        $meta->fill($request->all());
        // 保存资源
        $meta->save();
        // 清除缓存
        if (in_array($meta->type, ['module'])) {
            \Cache::forget("meta_modules");
        }
        return $this->edit($meta->id);
    }

    /**
     * Remove the specified resource from storage.
     * 从存储中移除指定的资源。
     * @param int $id
     * @done 根据 ID 查询对应资源
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        $meta = $this->getModel('meta')::find($id);
        $meta->timestamps = false;
        $meta->update([
            'deleted_at' => now()
        ]);

        \App\Models\Relationship::where('meta_id', request()->input('id'))->delete();

        return redirect(($this->moduleAlias ?? 'home'));
        // return $this->view('index');

    }
    /**
     * Summary of import
     * @param \Illuminate\Http\Request $request
     */
    public function import(Request $request)
    {
        if ($request->method() == 'GET')
            return;
        // $file = $request->file('file');
        // var_dump($file);
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //
            var_dump($request->file('file'));

            var_dump([
                'path' => $request->file->path(),
                'extension' => $request->file->extension(),
                'getPath' => $request->file->getPath(),
                'getPathInfo' => $request->file->getPathInfo(),
                'getClientOriginalName' => $request->file->getClientOriginalName(),
                'getClientOriginalExtension' => $request->file->getClientOriginalExtension(),
                'getMaxFilesize' => $request->file->getMaxFilesize(),
                'getErrorMessage' => $request->file->getErrorMessage(),
                'getError' => $request->file->getError(),
                'getPathname' => $request->file->getPathname(),
                'getClientMimeType' => $request->file->getClientMimeType(),
            ]);


            $fileModel = $this->getModel("file");
            $file = new $fileModel;
            $file->fill([
                'slug' => basename($request->file->hashName(), '.txt'),
                'name' => $request->file->getClientOriginalName(),
                'extension' => $request->file->getClientOriginalExtension(),
                'type' => $request->file->getClientMimeType(),
                'user_id' => \Auth::id(),
            ]);
            $file->save();

            $this->getModel('relationship')::insert([
                'meta_id' => $request->input('meta_id', 0),
                'file_id' => $file->id,
            ]);
            var_dump($file);

            $path = $request->file->storeAs('metas/' . $request->file->getClientOriginalExtension(), str_replace(['-', ' ', ':'], '_', $file->created_at) . '_' . $request->file->getClientOriginalName());
            var_dump($path);
            $file->timestamps = false;
            $file->update([
                'path' => $path,
            ]);
            $file->save();
            switch ($file->type) {
                case 'application/json':
                    $fileContent = \Storage::get($path);
                    $this->upsertModelData($request, json_decode($fileContent, true));
                    break;
                case 'md':
                    break;
                default:
                    break;
            }


        } else {
        }
        // return $this->index($request);
    }
    public function list(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
            'operation' => 'required|string',
        ]);
        $ids = explode('|', $request->input('ids'));
        $return = [
            "list" => $this->getModel('meta')::whereIn('id', $ids)->get(),
            "modules" => $this->getModel('meta')::with([
                'children' => function ($query) {
                    $query->where('type', 'module');
                }
            ])->where('type', 'module')->where('parent', 0)->get(),
        ];

        return $this->view('ssential.meta-form', $return);
    }
    public function export(Request $request)
    {
    }
    public function batch(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
            'operation' => 'required|string',
        ]);
        $ids = explode('|', $request->input('ids'));
        $list = $this->getModel('meta')::whereIn('id', $ids)->get();

        switch ($request->input('operation')) {
            case 'update':
            case 'copy':
            case 'delete':

                break;
            case 'remove':
                $request->whenFilled('module', function ($input) use (&$list) {
                    foreach ($list as $item) {
                        $item->fill(['parent' => $input]);
                        $item->save();
                    }
                });
                break;

            case 'export-json':
                $path = 'metas/' . date_format(now(), 'Y_m_d_H_i_s_ms') . '_metas.json';
                \Storage::put($path, json_encode(["metas" => $list], JSON_UNESCAPED_UNICODE));
                // return response()->download(\Storage::path($path), basename($path), ['content-type' => 'application/json']);

                return \Storage::download($path, basename($path));
                break;
            case 'export-csv':
            case 'export-xlsx':
            case 'export-pdf':
                break;
            default:
                break;
        }

        // var_dump($request->all());
        return $this->list($request);
        // $file = $request->file('file');
        // var_dump($file);

        // return $this->index($request);
    }

    public function move(Request $request)
    {
    }
    public function copy(Request $request)
    {
    }
    /**
     * 验证表单请求
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validata_item(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
        ]);
    }

    protected function validate_list(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
            'operation' => 'required|string',
        ]);
    }
}

