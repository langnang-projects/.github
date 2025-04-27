@extends('webpage::layouts.master')

@section('content')
  @foreach (array_filter($content->dependencies, function ($item) {
          return $item['type'] == 'css';
      }) as $style)
    <link rel="stylesheet" href="{{ $style['url'] }}">
  @endforeach
  <h1>{{ $content->title }}</h1>

  <p>
    This view is loaded from module: {!! config('webpage.name') !!}
  </p>
  @foreach (array_filter($content->dependencies, function ($item) {
          return $item['type'] == 'javascript';
      }) as $script)
    <script crossorigin="anonymous" src="{{ $script['url'] }}"></script>
  @endforeach
@endsection
