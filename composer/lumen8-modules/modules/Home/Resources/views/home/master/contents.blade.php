@extends($config['slug'] . '::layouts.' . $config['layout'])

@section('content')
  <div class="container">
    <h1>Contents</h1>
    @isset($paginator)
      @foreach ($paginator as $content)
        <div class="card card-default mb-3">
          <div class="card-header py-1">
            {{ $content->title }}
          </div>
          <div class="card-body py-2">
            <p class="mr-auto mb-0">
              {{ $content->title }}
            </p>
          </div>
          <div class="card-footer d-flex py-1">
            <span class="mr-auto"></span>
            <small>{{ $content->updated_at }}</small>
          </div>
        </div>
      @endforeach
    @endisset

    {{ $paginator->links() }}
  </div>
@endsection
