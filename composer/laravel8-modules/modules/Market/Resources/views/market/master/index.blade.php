@extends($config['slug'] . '::layouts.' . $config['layout'])

@section('title')
  {{ $config['name'] }}
@endsection

@section('main')
  <div class="container">
    <div class="row mb-3">
      <div class="col-12 px-1">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="holder.js/1024x480?auto=yes" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Some representative placeholder content for the first slide.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="holder.js/1024x480?auto=yes" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Some representative placeholder content for the second slide.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="holder.js/1024x480?auto=yes" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </button>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 px-1">
        <div class="card mb-3">
          <div class="card-header d-flex">
            <h4 class="flex-grow-1 mb-0" style="line-height: 1.95rem;">NPM Packages </h4>
            <form class="form-inline mb-0" action="market/npm" method="get">
              <div class="form-group ml-1">
                <input type="text" class="form-control form-control-sm" name="search" placeholder="Search...">
              </div>
              <div class="form-group ml-1">
                <button class="btn btn-outline-primary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @foreach ($npm ?? [] as $project)
        <div class="col-3 mb-2 px-1">
          <a class="card text-white" href="market/npm/{{ $project['name'] ?? $project['title'] }}">
            <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img" style="height: 9rem;" alt="...">
            <div class="card-img-overlay">
              <h5 class="card-title text-truncate">{{ $project['name'] ?? $project['title'] }}</h5>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-12 px-1">
        <div class="card mb-3">
          <div class="card-header d-flex">
            <h3 class="flex-grow-1 mb-0">Modules</h3>
            <button type="button" class="btn btn-sm rounded-circle ml-1 btn-outline-info">
              <i class="bi bi-arrow-repeat"></i>
            </button>
            <button type="button" class="btn btn-sm rounded-circle ml-1 btn-outline-info">
              <i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
            </button>
          </div>
          <div class="row card-body d-none">
            <div class="d-flex justify-content-center">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            @foreach ($moduleProjects ?? [] as $project)
              <div class="col-4 mb-2 px-2">
                <div class="card text-white">
                  <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img" style="height: 10rem;" alt="...">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-truncate">{{ $project['title'] ?? $project['name'] }}</h5>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 px-1">
        <div class="card mb-3">
          <div class="card-header">
            <h3 class="mb-0">Examples</h3>
          </div>
          <div class="row card-body">
            @foreach ($exampleProjects ?? [] as $project)
              <div class="col-4 mb-2 px-2">
                <div class="card text-white">
                  <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img" style="height: 10rem;"
                    alt="...">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-truncate">{{ $project['title'] ?? $project['name'] }}</h5>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 px-1">
        <div class="card mb-3">
          <div class="card-header">
            <h3 class="mb-0">Themes</h3>
          </div>
          <div class="row card-body">
            @foreach ($themeProjects ?? [] as $project)
              <div class="col-4 mb-2 px-2">
                <div class="card text-white">
                  <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img" style="height: 10rem;"
                    alt="...">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-truncate">{{ $project['title'] ?? $project['name'] }}</h5>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 px-1">
        <div class="card mb-3">
          <div class="card-header">
            <h3 class="mb-0">Softwares</h3>
          </div>
          <div class="row card-body">
            @foreach ($softwareProjects ?? [] as $project)
              <div class="col-4 mb-2 px-2">
                <div class="card text-white">
                  <img src="holder.js/180x100?auto=yes&bg=343a40" class="card-img" style="height: 10rem;"
                    alt="...">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-truncate">{{ $project['title'] }}</h5>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>


  </div>
@endsection

@push('scripts')
  <script>
    // http://api.jsdelivr.com/v1/jsdelivr/libraries?name=jquery
    axios.get('http://api.jsdelivr.com/v1/jsdelivr/libraries?name=jquery').then(res => {
      console.log("npm ~ packages", res)

    })
  </script>
@endpush
