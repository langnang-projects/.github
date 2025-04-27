@extends($module_config['layout'] . '::layouts.main')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ Config::get($module . '.name') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">应用管理</li>
            <li class="breadcrumb-item"><a href="/admin/module-market">应用市场</a></li>
            <li class="breadcrumb-item"><a
                href="/admin/module-market/{{ Config::get($module . '.module') }}">{{ Config::get($module . '.name') }}</a>
            </li>
            <li class="breadcrumb-item active">Install</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->


    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-sm-10 offset-sm-1">
          <div class="progress" style="height: 2rem; border-radius: 6px;">
            <div
              class="progress-bar @if ($_GET['step'] < 1) bg-transparent @elseif($_GET['step'] == 1) bg-secondary @else bg-success @endif"
              type="button" style="width: 20%">
              <b>1：起步</b>
            </div>
            <div
              class="progress-bar @if ($_GET['step'] < 2) bg-transparent @elseif($_GET['step'] == 2) bg-secondary @else bg-success @endif"
              type="button" style="width: 20%">
              <b>2：配置</b>
            </div>
            <div
              class="progress-bar @if ($_GET['step'] < 3) bg-transparent @elseif($_GET['step'] == 3) bg-secondary @else bg-success @endif"
              type="button" style="width: 20%">
              <b>3：数据库</b>
            </div>
            <div
              class="progress-bar @if ($_GET['step'] < 4) bg-transparent @elseif($_GET['step'] == 4) bg-secondary @else bg-success @endif"
              type="button" style="width: 20%">
              <b>4：基础数据</b>
            </div>
            <div
              class="progress-bar @if ($_GET['step'] < 5) bg-transparent @elseif($_GET['step'] == 5) bg-secondary @else bg-success @endif"
              type="button" style="width: 20%">
              <b>5：结果</b>
            </div>
          </div>
        </div>
      </div>
      @include($module . '::install')
    </div>
  </section>
  <!-- /.content -->
@endsection
