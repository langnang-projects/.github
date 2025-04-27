@extends($layout)



@section('content')
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

      @foreach ($projects ?? [] as $project)
        <div class="col-12 mb-2 px-1">
          <a class="card" href="npm/{{ $project['name'] ?? $project['title'] }}">
            {{-- <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img sr-only" style="height: 9rem;" alt="..."> --}}
            {{-- <div class="card-img-overlay">
              <h5 class="card-title text-truncate">{{ $project['name'] ?? $project['title'] }}</h5>
            </div> --}}
            <div class="card-body py-1">
              <div class="card-title">
                <h5 class="d-inline">{{ $project['name'] }}</h5>
                <span class="badge badge-pill badge-primary small px-1 py-1">{{ $project['lastversion'] }}</span>
              </div>
              <h6 class="card-subtitle mb-0 text-muted">{{ $project['description'] }}</h6>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <x-pagination :paginator="$projects"></x-pagination>
  </div>
@endsection

@push('scripts')
  <script></script>
@endpush
