@extends('adminlte::layouts.body', [
    'bodyClass' => 'hold-transition layout-fixed layout-top-nav layout-navbar-fixed',
])

@section('main')
  <div class="wrapper">
    @include('adminlte::layouts.navbar')
    <div class="content-wrapper">
      @yield('content')
    </div>
    @include('adminlte::layouts.footer')
  </div>
@endsection
