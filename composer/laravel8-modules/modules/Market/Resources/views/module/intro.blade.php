@extends($module_config['layout'] . '::layouts.main')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ Config::get($slug . '.name') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">应用管理</li>
            <li class="breadcrumb-item"><a href="/admin/module-market">应用市场</a></li>
            <li class="breadcrumb-item active">{{ Config::get($slug . '.name') }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <div class="col-sm-9">
        @if (File::exists('modules/' . Config::get($slug . '.name') . '/resources/views/intro.blade.php'))
          @include($slug . '::intro')
        @elseif (File::exists('modules/' . Config::get($slug . '.name') . '/README.md'))
          {!! Str::markdown(File::get('modules/' . Config::get($slug . '.name') . '/README.md')) !!}
        @else
          <p>Empty Intro</p>
        @endif
      </div>
      <div class="col-sm-3">
        <a type="button" class="btn btn-primary btn-lg btn-block"
          href="/admin/module-market/{{ Config::get($slug . '.slug') }}/install">Install</a>
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
