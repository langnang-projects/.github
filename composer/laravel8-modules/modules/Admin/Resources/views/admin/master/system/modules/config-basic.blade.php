<div class="row row-cols-1 row-cols-md-2">
  <form class="col" method="POST">
    @csrf
    <input type="hidden" class="form-control" name='_target' value="basic">

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Basic <small class="text-muted">基础</small></h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="card-body">
        <div class="form-group">
          <label>Name <small class="text-muted">模块名称</small></label>
          <input type="text" class="form-control" name='title' value="{{ $moduleConfig['name'] ?? '' }}" readonly>
        </div>
        <div class="form-group">
          <label>Slug <small class="text-muted">模块别名</small></label>
          <input type="text" class="form-control" name='slug' value="{{ $moduleConfig['slug'] ?? '' }}">
        </div>
        <div class="form-group">
          <label>Title <small class="text-muted">模块标题</small></label>
          <input type="text" class="form-control" name='title' value="{{ $moduleConfig['title'] ?? '' }}">
        </div>
        <div class="form-group">
          <label>Type <small class="text-muted">模块类型: project, theme, extra, other</small></label>
          <input type="text" class="form-control" name='type' value="{{ $moduleConfig['type'] ?? 'project' }}">
        </div>
        <div class="form-group">
          <label>Description <small class="text-muted">模块说明</small></label>
          <textarea class="form-control" name='description' rows="3">{{ $moduleConfig['description'] ?? '' }}</textarea>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </form>
  <form class="col" method="POST">
    @csrf
    <input type="hidden" class="form-control" name='_target' value="view">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">View <small class="text-muted">视图</small></h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="card-body">
        <div class="form-group">
          <label>UI <small class="text-muted">模块界面框架</small></label>
          <input type="text" class="form-control" name='ui'
            value="{{ Arr::get($moduleConfig, 'ui', 'bootstrap') }}">
        </div>
        <div class="form-group">
          <label>Component <small class="text-muted">模块组件</small></label>
          <input type="text" class="form-control" name='component'
            value="{{ Arr::get($moduleConfig, 'component') }}">
        </div>
        <div class="form-group">
          <label>Layout <small class="text-muted">模块布局</small></label>
          <select class="form-control" name="layout">
            @foreach (Arr::get($moduleConfig, 'layouts', []) as $layout)
              @php
                $layout = Str::of($layout)->after(config('modules.config.files.layouts'))->before('.blade');
              @endphp
              <option value="{{ $layout }}" @if (Arr::get($moduleConfig, 'layout', 'master') == $layout) selected @endif>
                {{ $layout }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Theme <small class="text-muted">模块主题</small></label>
          <input type="text" class="form-control" name='theme'
            value="{{ Arr::get($moduleConfig, 'theme', 'default') }}">
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </form>
  <form class="col" method="POST">
    @csrf
    <input type="hidden" class="form-control" name='_target' value="route">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Route <small class="text-muted">路由</small></h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="card-body">
        <div class="form-group">
          <label>Prefix <small class="text-muted">模块前缀</small></label>
          <input type="text" class="form-control" name='prefix'
            value="{{ Arr::get($moduleConfig, 'prefix', '') }}">
        </div>
        <div class="form-group">
          <label>Web Prefix <small class="text-muted">模块前缀</small></label>
          <input type="text" class="form-control" name='web.prefix'
            value="{{ Arr::get($moduleConfig, 'web.prefix', Arr::get($moduleConfig, 'prefix', '')) }}">
        </div>
        <div class="form-group">
          <label>API Prefix <small class="text-muted">模块前缀</small></label>
          <input type="text" class="form-control" name='api.prefix'
            value="{{ Arr::get($moduleConfig, 'api.prefix', Arr::get($moduleConfig, 'prefix', '')) }}">
        </div>
        <div class="form-group">
          <label>Table Prefix <small class="text-muted">模块前缀</small></label>
          <input type="text" class="form-control" name='db.prefix'
            value="{{ Arr::get($moduleConfig, 'db.prefix', Arr::get($moduleConfig, 'prefix', '')) }}">
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </form>
  <form class="col" method="POST">
    @csrf
    <div class="card card-default d-none">
      <div class="card-header">
        <h3 class="card-title">Layout <small class="text-muted">布局</small></h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="card-body">
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </form>
  <form class="col" method="POST">
    @csrf
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Other <small class="text-muted">其它</small></h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="card-body">
        <div class="form-group">
          <label>Key <small class="text-muted">模块...</small></label>
          <input type="text" class="form-control" name='key' value="{{ $moduleConfig['key'] ?? '' }}">
        </div>
        <div class="form-group">
          <label>MD5 <small class="text-muted">模块...</small></label>
          <input type="text" class="form-control" name='md5' value="{{ $moduleConfig['md5'] ?? '' }}">
        </div>
        <div class="form-group">
          <label>UUID <small class="text-muted">模块...</small></label>
          <input type="text" class="form-control" name='uuid'
            value="{{ Arr::get($moduleConfig, 'uuid', Str::UUID()) }}" readonly>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </form>
</div>
