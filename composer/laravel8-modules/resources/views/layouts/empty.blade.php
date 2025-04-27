<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'Modular') | {{ env('APP_NAME') }}</title>

  <link rel="shortcut icon" href="{{ env('APP_URL') }}favicon.ico" type="image/x-icon">


  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Fonts -->
  {{--
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet"> --}}

  <!-- Styles -->
  {{--
  <link rel="stylesheet" href="/public/app/css/app.css"> --}}

  @section('head')
    @if (\View::exists('master.shared.head'))
      @include('master.shared.head')
    @endif
  @show

  @stack('styles')
</head>

<body>

  @yield('main')

  @sectionMissing('main')
    @section('header')
      @if (View::exists('master.shared.header') && !empty($config))
        @include('master.shared.header')
      @endif
    @show

    @yield('sidebar')

    <div class="wrapper-content" style="min-height: calc(100vh - @empty($config) 88px @else 152px @endif)">
    @yield('content')
  </div>

  @section('footer')
  @if (View::exists('master.shared.footer'))
    @include('master.shared.footer')
  @endif
  @show
  @endif

  <script src="https://unpkg.com/axios"></script>
  <script src="https://unpkg.com/jquery"></script>
  <script src="https://unpkg.com/popper.js"></script>
  <script src="https://unpkg.com/bootstrap@4"></script>
  <script src="https://unpkg.com/lodash"></script>
  <script src="https://unpkg.com/holderjs"></script>
  <script src="https://unpkg.com/mockjs"></script>
  <script src="https://unpkg.com/moment"></script>
  <script src="https://unpkg.com/masonry-layout"></script>
  {{-- <x-scripts :props="[
      ['axios', 'axios.min' ], ['jquery', 'jquery.min' ], ['popper.js', 'popper.min' ], [ 'bootstrap'
      , 'js/bootstrap.min' ], ['lodash', 'lodash.min' ], ['holderjs', 'holder.min' ], ['mockjs', 'mock-min' ],
      ['moment', 'moment' ], ['masonry-layout', 'masonry.pkgd.min' ], ['public/app/js/app'], ]">
      </x-scripts> --}}

      @stack('scripts')
</body>

</html>
