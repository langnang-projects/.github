<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class AdminContentController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        \DB::enableQueryLog();
        \DB::flushQueryLog();
        $paginator = $this->getModel('content')::with([
            'relationships',
            'belongsToMeta'
        ])->whereHas('belongsToMeta', function ($query) {
            $query->where('meta_id', $this->getAttribute('id'));
        })->withCount('children')
            ->where('slug', 'like', '%' . $request->input('slug') . '%')
            ->where('title', 'like', '%' . $request->input('title') . '%')
            ->whereIn('type', $request->filled('type') ? [$request->input('type')] : array_keys($this->getOption('content.type')))
            ->whereIn('status', $request->filled('status') ? [$request->input('status')] : array_keys($this->getOption('content.status')))
            ->where('parent', $request->input('parent', 0))
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->paginate(20);

        $this->setAttributeSql('select_content_list', \DB::getQueryLog());
        \DB::disableQueryLog();
        return $this->view('ssential.content-table', [
            'paginator' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $model = $this->getModel('content');
        $return = [
            'item' => new $model(request()->all())
        ];
        return $this->view('ssential.content-form', $return);
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
        $model = $this->getModel('content');
        // 2025-01-09 14:14:50 使用模型工厂创建新资源
        $return = [
            'item' => \Arr::first($model::factory(1)->make()),
        ];
        // 2025-01-09 14:14:41 重置或替换为 Request 中数据
        $return['item']['parent'] = $request->input('parent', 0);
        $return['item']['count'] = $request->input('count', 0);
        $return['item']['order'] = $request->input('order', 0);
        $return['item']['template'] = $request->input('template', 0);
        return $this->view('ssential.content-form', $return);
    }
    /**
     * Store a newly created resource in storage.
     * 将新创建的资源存储在存储器中。
     * @param Request $request
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 2025-01-09 14:10:15 验证表单
        $this->validate_item($request);
        // 2025-01-09 14:10:24 绑定用户
        $request->merge(['user_id' => \Auth::id()]);
        $model = $this->getModel('content');

        $content = new $model;
        $content->fill($request->all());
        $content->save();
        if (empty($content->slug)) {
            // 2025-01-09 14:11:33 若标识为空，则默认为 ID
            $content->slug = $content->id;
            $content->save();
        }
        // 2025-01-09 14:10:41 清除原有关联
        // TODO 清除当前模块下的对应关联(category,tag)
        $this->getModel('relationship')::where("content_id", $content->id)->delete();
        // 2025-01-09 14:10:41 增加指定关联
        $this->getModel('relationship')::insert([
            "meta_id" => $this->getAttribute('id'),
            "content_id" => $content->id,
        ]);
        // var_dump($content['slug']);
        // return $this->edit($content->id);
        // return $this->edit($content->id);
        // 2025-01-09 14:10:30 重定向
        return redirect(str_replace(['create', 'factory'], $content->id, $request->path()));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $return = [
            'item' => $this->getModel('content')::with(['fields', 'relationships'])->find($id),
            // 'contents' => $this->getModel('content')::with(['children'])
            //     ->whereIn('type', ['template',])
            //     ->whereKeyNot($id)
            //     ->whereNull('deleted_at')
            //     ->get()
        ];
        return $this->view('ssential.content-form', $return);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate_item($request);
        $request->merge(['user_id' => \Auth::id()]);
        $content = $this->getModel('content')::find($id);
        $content->fill($request->all());
        if (empty($content->slug)) {
            $content->slug = $content->id;
        }
        $content->save();

        $this->getModel('relationship')::where("content_id", $content->id)->delete();
        $this->getModel('relationship')::insert([
            "meta_id" => $this->getAttribute('id'),
            "content_id" => $content->id,
        ]);

        return $this->edit($content->id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        $content = $this->getModel('content')::find($id);
        $content->timestamps = false;
        $content->update([
            'deleted_at' => now()
        ]);

        \App\Models\Relationship::where('content_id', request()->input('id'))->delete();

        return redirect(($this->moduleAlias ?? 'home'));
        // return $this->view('index');

    }

    protected function validate_item(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
        ]);
    }
}

