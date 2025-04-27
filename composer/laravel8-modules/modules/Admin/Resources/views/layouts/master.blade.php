<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/summernote/summernote-bs4.min.css') }}">
  <style>
    .main-header .nav-link {
      height: auto;
    }

    .sidebar-mini .xdebug-var-dump {
      transition: margin-left .3s ease-in-out;
      margin-left: 250px;
    }

    .sidebar-mini.sidebar-collapse .xdebug-var-dump {
      margin-left: 4.6rem !important
    }

    .nav-sidebar .nav-treeview .nav-link {
      padding-left: 1.5rem;
    }

    .nav-sidebar .nav-treeview .nav-treeview .nav-link {
      padding-left: 2rem;
    }

    .card-title {
      font-size: 1.3rem;
    }

    .pagination {
      margin-bottom: 0;
    }


    .input-group-sm>.custom-file,
    .input-group-sm>.custom-file>.custom-file-input,
    .input-group-sm>.custom-file>.custom-file-label,
    .input-group-sm>.custom-file>.custom-file-label::after {
      height: calc(1.8125rem + 2px);
      padding: .25rem .5rem;
      font-size: .875rem;
    }
  </style>
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center d-none">
      <img class="animation__shake" src="{{ asset('/modules/Admin/Public/master/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>


    @section('main')
      <div class="wrapper">
        {{-- @section('preloader') @include('adminlte::layouts.preloader') @show --}}
        @section('navbar') @include('admin::master.shared.navbar') @show
        @section('sidebar') @include('admin::master.shared.sidebar') @show
        <!-- Content Wrapper. Contains page content -->
        <div class="container-flud content-wrapper" style="height: calc(100vh - 114px); overflow-y: auto; min-height: auto;">
          <!-- Content Header (Page header) -->
          <div class="content-header px-3 d-flex align-items-center py-2">

            <h1 class="m-0 mr-auto">{{ Arr::get($admin, 'active_category.name', 'Dashboard') }}

              <small class="text-muted"><em>{{ Arr::get($admin, 'active_category.description') }}</em> </small>
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              @foreach (Arr::get($admin, 'categories', []) as $category)
                @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category['slug'])))
                  <li class="breadcrumb-item"><a href="{{ url(Str::replace(':', '/', $category['slug'])) }}">{{ $category['name'] }}</a></li>
                @endif
                @foreach (Arr::get($category, 'children', []) as $category_child)
                  @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category_child['slug'])))
                    <li class="breadcrumb-item"><a href="{{ url(Str::replace(':', '/', $category_child['slug'])) }}">{{ $category_child['name'] }}</a></li>
                  @endif
                @endforeach
              @endforeach
              @foreach ($module['menu_actives'] ?? [] as $menu_item)
                @if ($loop->last)
                  <li class="breadcrumb-item active">{{ $menu_item['title'] }}</li>
                @else
                  <li class="breadcrumb-item"><a href="{{ $menu_item['path'] }}">{{ $menu_item['title'] }}</a></li>
                @endif
              @endforeach
            </ol>
          </div>
          <!-- /.content-header -->
          @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @section('footer') @include('admin::master.shared.footer') @show
        @section('control-sidebar') @include('admin::master.shared.control-sidebar') @show
      </div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('/modules/Admin/Public/master/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/modules/Admin/Public/master/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/modules/Admin/Public/master/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/modules/Admin/Public/master/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('/modules/Admin/Public/master/js/demo.js') }}"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('/modules/Admin/Public/master/js/pages/dashboard.js') }}"></script> --}}

    @stack('scripts')
  </body>

  </html>
