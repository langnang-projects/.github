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
          <h1 class="display-5">{{ $project['name'] }}</h1>
          <p class="lead small">{{ $project['description'] }}</p>
          <hr class="my-3">
          <form action="" method="post">
            @csrf
            <div class="input-group">
              <select class="form-control" name="version">
                @foreach ($project['versions'] ?? [] as $version)
                  <option value="{{ $version }}" @if (request()->input('version') == $version) selected @endif>
                    {{ $version }}
                  </option>
                @endforeach
              </select>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Install</button>
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
      @if (request()->method() == 'POST')
        <x-market::admin.install-card :props="array_merge($project, [
            'type' => 'npm',
        ])"></x-market::admin.install-card>
      @endif
    </div>
  </div>
@endsection

@push('scripts')
  <script></script>
@endpush
