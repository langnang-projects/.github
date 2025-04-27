@extends($module['slug'] . '::layouts.' . $module['layout'])

@section('content')
  @if (View::exists($moduleConfig['slug'] . '::' . $module['slug'] . '.index'))
    @include($moduleConfig['slug'] . '::' . $module['slug'] . '.index')
  @endif
@endsection
