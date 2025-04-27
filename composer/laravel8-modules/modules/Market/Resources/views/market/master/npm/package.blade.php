@extends($layout)



@section('main')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6 px-1">
        <form action="" method="get">
          <div class="input-group input-group-lg rounded-pill">
            <input type="text" class="form-control" name="search" value="{{ request()->input('search') }}"
              style="border-top-left-radius: 50rem;border-bottom-left-radius: 50rem;">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit"
                style="border-top-right-radius: 50rem;border-bottom-right-radius: 50rem;">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="jumbotron py-5 mb-3">
          <h1 class="display-5">{{ $package['name'] }}</h1>
          <p class="lead">{{ $project['description'] }}</p>
          <hr class="my-3">
          <ul class="list pl-3">
            <li class="text-muted small">若未勾选列表中选项，将按照当前文件夹路径安装。</li>
            <li class="text-muted small">若已勾选列表中选项，将会安装对应已勾选的文件。</li>
          </ul>

          <form class="d-none" action="" method="post">
            @csrf
            <div class="input-group">
              <select class="form-control" name="version" disabled>
                @foreach ($project['versions'] ?? [] as $version)
                  <option value="{{ $version }}" @if (request()->input('version') == $version) selected @endif>
                    {{ $version }}
                  </option>
                @endforeach
              </select>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" disabled>Install</button>
              </div>
            </div>
          </form>
          <p class="d-none">It uses utility classes for typography and spacing to space content out within the larger
            container.</p>
          <a class="btn btn-primary btn-lg d-none" href="#" role="button">Learn more</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <form method="post" class="list-group">
          @csrf
          <li class="list-group-item d-flex py-2 @if (!request()->input('path')) disabled @endif">
            <a class="mr-auto" href="?path={{ Str::beforeLast(request()->input('path'), '/') }}">
              <i class="fa-solid fa-folder-open"></i>
              {{ $package['path'] . '/' }}
            </a>
            <button class="btn btn-sm btn-primary" type="submit" style="padding: .03rem .5rem;">Submit</button>
          </li>
          @foreach ($package['files'] ?? [] as $file)
            @switch($file['type'])
              @case('dir')
                <a class="list-group-item form-check py-2" style="padding-left: 2.5rem;"
                  href="?path={{ (request()->filled('path') ? request()->input('path') . '/' : '') . $file['basename'] }}">
                  <input class="form-check-input" type="checkbox" name="files[]" value="{{ $file['basename'] }}"
                    id="defaultCheck1">
                  <i class="fa-solid fa-folder"></i>
                  {{ $file['basename'] }}
                </a>
              @break

              @case('file')
                <li class="list-group-item form-check py-2" style="padding-left: 2.5rem;">
                  <input class="form-check-input" type="checkbox" name="files[]" value="{{ $file['basename'] }}"
                    id="defaultCheck1">
                  <i class="fa-solid fa-file"></i>
                  {{ $file['basename'] }}
                </li>
              @break

              @default
              @break
            @endswitch
          @endforeach
        </form>
      </div>
    </div>

  </div>
@endsection

@push('scripts')
  <script></script>
@endpush
