@extends($layout)


@section('content')
  <div class="container">
    <div class="row">
      <div class="col-9">
        @foreach ($contents ?? [] as $content)
          <div class="card mb-3">
            <a class="card-header px-3" href="/{{ $config['slug'] }}/content/{{ $content['cid'] }}">
              {{ $content['title'] ?? '' }}
            </a>
            <div class="card-body py-3 px-2">
              {{ $content['description'] ?? '' }}
            </div>
            <div class="card-footer small px-3 py-1">
              作者: {{ $content['user'] }}
              时间: {{ $content['release_at'] ?? $content['updated_at'] }}
              分类:
              @foreach ($content['metas'] ?? [] as $meta)
                <a href="/{{ $config['slug'] }}/meta/{{ $meta['mid'] }}"></a>
              @endforeach
            </div>
          </div>
        @endforeach

        {{ $contents->withQueryString()->links() }}
      </div>

      <div class="col-3">
        <form method="GET">
          <div class="form-group">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control form-control-sm" name="title" placeholder="title"
                value="{{ request()->input('title') }}">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </div>
          </div>
        </form>

        <div class="card mb-3">
          <div class="card-header p-2">最新文章</div>
        </div>
        <div class="card mb-3">
          <div class="card-header p-2">最近回复</div>
        </div>
        <div class="card mb-3">
          <div class="card-header p-2">目录分类</div>
        </div>
        <div class="card mb-3">
          <div class="card-header p-2">归档</div>
        </div>
        <div class="card mb-3">
          <div class="card-header p-2">其它</div>
        </div>
      </div>
    </div>
  </div>
@endsection
