<div class="card mb-2">
  <div class="card-header py-2 pl-3 d-flex align-items-center">
    <h3 class="mr-auto mb-0">{{ $title ?? '' }}</h3>
    <form class="form-inline mb-0" name="table">
      <input type="hidden" name="parent" value="{{ request()->input('parent', 0) }}">
      <div class="form-group ml-1">
        <select class="form-control form-control-sm" name="module" placeholder="Module" style="width: 120px;">
          <option value="">--Module--</option>
          @foreach (\Module::allEnabled() as $moduleName => $moduleObject)
            <option value="{{ $moduleObject->getAlias() }}" @if (request()->input('module') == $moduleObject->getAlias()) selected @endif>{{ $moduleName }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group ml-1">
        <input type="text" name="slug" class="form-control form-control-sm" placeholder="--Slug--" value="{{ request()->input('slug') }}" style="width: 120px;">
      </div>
      <div class="form-group ml-1">
        <input type="text" name="title" class="form-control form-control-sm" placeholder="--Title--" value="{{ request()->input('title') }}" style="width: 120px;">
      </div>
      <div class="form-group ml-1">
        <select class="form-control form-control-sm" name="type" style="width: 120px;">
          <option value="">--Type--</option>
          @foreach (Arr::get($options, 'meta.type') as $option)
            <option value="{{ $option['value'] }}" @if (request()->input('type') == $option['value']) selected @endif>{{ $option['name'] }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group ml-1">
        <select class="form-control form-control-sm" name="status" style="width: 120px;">
          <option value="">--Status--</option>
          @foreach (Arr::get($options, 'meta.status') as $option)
            <option value="{{ $option['value'] }}" @if (request()->input('status') == $option['value']) selected @endif>{{ $option['name'] }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-sm btn-primary form-control form-control-sm ml-1">
        查询
      </button>
      <a href="metas" class="btn btn-sm btn-secondary form-control form-control-sm ml-1">
        重置
      </a>
      <div class="btn-group btn-group-sm ml-1" role="group">
        <button type="button" class="btn btn-info">下载</button>
        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <button class="dropdown-item">CSV</button>
          <button class="dropdown-item">Excel</button>
          <button class="dropdown-item">JSON</button>
          <div class="dropdown-divider my-1"></div>
          <button class="dropdown-item">PDF</button>
          <div class="dropdown-divider my-1"></div>
          <button class="dropdown-item">SQL</button>
        </div>
      </div>
    </form>
  </div>
  <div class="card-body" style="height: calc(100vh - 275px);">

  </div>
  <div class="card-footer py-2 clearfix d-flex align-items-center">
    <form class="form-inline mb-0 mr-1" action="metas/batch" method="get" name="batch-operation">
      <input type="hidden" name="ids" value="">
      <div class="form-check form-check-inline">
        <input class="form-check-input checkbox-toggle mr-0" type="checkbox">
        <button type="button" class="btn btn-sm btn-link form-check-label" style="width: 60px;">全选</button>
      </div>
      <div class="form-group mb-0">
        <select name="operation" class="form-control form-control-sm">
          <option>选中项：</option>
          <option value="update">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编辑</option>
          <option value="copy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;复制</option>
          <option value="delete">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;删除</option>
          <option value="remove">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;移动</option>

          <optgroup label="导出：">
            <option value="export-json">JSON</option>
            <option value="export-csv">CSV</option>
            <option value="export-xlsx">Excel</option>
            <option value="export-pdf">PDF</option>
          </optgroup>
        </select>
      </div>
    </form>
    <form class="form-inline mb-0 mr-1" method="post" enctype="multipart/form-data">
      @csrf
      <div class="input-group input-group-sm">
        <div class="custom-file" style="width: 160px;">
          <input type="file" class="custom-file-input" accept=".json,.xlsx,.csv,.md,.txt" name="file">
          <label class="custom-file-label justify-content-start text-truncate">Choose file...</label>
        </div>
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit">上传</button>
        </div>
      </div>
    </form>
    <div class="mr-auto">
      <a type="button" class="btn btn-sm btn-primary" href="metas/create?{{ Arr::query(request()->all()) }}">新增</a>
      <button type="button" class="btn btn-sm btn-secondary">打印</button>
      <button type="button" class="btn btn-sm btn-secondary">下载</button>
    </div>
    @isset($paginator)
      <span class="px-1"> 共 {{ $paginator->total() }} 条</span>
      <span class="px-1"> {{ $paginator->currentPage() }}/{{ $paginator->count() }} </span>
      {{ $paginator->onEachSide(2)->withQueryString(['slug', 'title', 'type', 'status'])->links() }}
    @endisset

  </div>
</div>
