@empty($package)
  <div class="row">
    <div class="col-md-12">
      <form action="">
        @foreach (request()->except('search') as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search" name="search"
            value="{{ request()->input('search') }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Submit</button>
          </div>
        </div>
      </form>


    </div>
    @foreach ($projects ?? [] as $project)
      <div class="col-md-3 col-sm-6 col-12">
        <a class="info-box" href="?from=jsdelivr&name={{ $project['name'] }}">
          <div class="info-box-content">
            <span class="info-box-text">{{ $project['name'] }}</span>
          </div>
          <!-- /.info-box-content -->
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    @endforeach
  </div>
@else
  <div class="row mb-2">
    <div class="col-md-12">
      <div class="jumbotron mb-2">
        <h1 class="display-4">{{ $package['name'] }}</h1>
      </div>
      <ul class="list-group">
        @foreach ($package['tags'] ?? [] as $version)
          <li class="list-group-item">{{ $version }}</li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-12">
      <div class="input-group">
        <select class="form-control">
          @foreach ($package['versions'] ?? [] as $version)
            <option value="{{ $version['version'] }}">
              {{ $version['version'] }}
            </option>
          @endforeach
        </select>
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button">Submit</button>
        </div>
      </div>
      <ul class="list-group d-none">
        @foreach ($package['versions'] ?? [] as $version)
          <a class="list-group-item" target="_blank"
            href="https://registry.npmjs.org/{{ $package['name'] }}/-/{{ $package['name'] }}-{{ $version['version'] }}.tgz">{{ $version['version'] }}</a>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="row row-cols-4">
    @foreach ($package['versions'] ?? [] as $index => $version)
      @php
        $version_url =
            'https://registry.npmjs.org/' .
            $package['name'] .
            '/-/' .
            $package['name'] .
            '-' .
            $version['version'] .
            '.tgz';
      @endphp
      <x-market::admin.install-card :props="array_merge($version, $package, [
          'versions' => [$version['version']],
          'version_url' => $version_url,
          'installed' => isset($project_installed['versions'][$version['version']]),
      ])"></x-market::admin.install-card>
    @endforeach
  </div>
@endempty

@push('scripts')
  <script>
    console.log(123);
  </script>
@endpush
