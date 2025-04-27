@extends($module['slug'] . '::layouts.' . $module['layout'])


@section('content')
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        @foreach ($modules as $module => $moduleConig)
          <div class="col-12 col-sm-6 col-md-3">
            <a href="modules/{{ strtolower($module) }}" class="info-box">
              <div class="info-box-content">
                <span class="info-box-text">{{ $module }}</span>
              </div>
              <!-- /.info-box-content -->
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        @endforeach
      </div>
    </div>
  </section>
@endsection
