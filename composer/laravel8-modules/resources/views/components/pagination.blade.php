@props(['paginator', 'layout' => 'total, prev, pager, next', 'page-sizes' => [100, 200, 300, 400]])

@isset($paginator)
  <div>

    <nav class="d-flex align-middle" aria-label="Page navigation example">
      @if (substr($layout, 'total') > -1)
        <div class="align-middle">共{{ $paginator->total() }}条</div>
      @endif
      <div class="align-middle">
        第{{ $paginator->currentPage() }}页{{ $paginator->firstItem() }}~{{ $paginator->lastItem() }}</div>
      <form class="form-inline mb-0 mr-2">
        <input type="hidden" name="search" value="{{ request()->input('search') }}">
        <div class="form-group ml-2">
          <select class="form-control" name="size">
            <option value="5" @if ($paginator->perPage() == '5') selected @endif>5</option>
            <option value="10" @if ($paginator->perPage() == '10') selected @endif>10</option>
            <option value="15" @if ($paginator->perPage() == '15') selected @endif>15</option>
            <option value="20" @if ($paginator->perPage() == '20') selected @endif>20</option>
            <option value="30" @if ($paginator->perPage() == '30') selected @endif>30</option>
            <option value="50" @if ($paginator->perPage() == '50') selected @endif>50</option>
          </select>
        </div>
        <div class="form-group ml-2">
          <input type="text" class="form-control" name="page" value="{{ $paginator->currentPage() }}"
            style="width: 48px;">
        </div>
        <div class="form-group ml-2">
          <button class="btn btn-outline-primary" type="submit">
            GO!
          </button>
        </div>
      </form>
      {{-- {{ $paginator->withQueryString()->onEachSide(5)->links() }} --}}
      <ul class="pagination mb-0">
        <li class="page-item"><a class="page-link px-2" href="{{ $paginator->url(1) }}">
            <i class="bi bi-chevron-bar-left" style="font-size: 1.25rem;"></i> </a></li>
        <li class="page-item"><a class="page-link px-2" href="{{ $paginator->previousPageUrl() }}">
            <i class="bi bi-chevron-double-left" style="font-size: 1.25rem;"></i>
          </a></li>
        @for ($i = $paginator->currentPage() - 5; $i < $paginator->currentPage(); $i++)
          @if ($i > 0)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
          @endif
        @endfor
        <li class="page-item active">
          <a class="page-link" href="{{ $paginator->url($paginator->currentPage()) }}">
            {{ $paginator->currentPage() }}
          </a>
        </li>
        @for ($i = $paginator->currentPage() + 1; $i <= $paginator->currentPage() + 5; $i++)
          @if ($i <= $paginator->lastPage())
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
          @endif
        @endfor
        <li class="page-item"><a class="page-link px-2" href="{{ $paginator->nextPageUrl() }}">
            <i class="bi bi-chevron-double-right" style="font-size: 1.25rem;"></i>
          </a></li>
        <li class="page-item"><a class="page-link px-2" href="{{ $paginator->url($paginator->lastPage()) }}">
            <i class="bi bi-chevron-bar-right" style="font-size: 1.25rem;"></i>
          </a></li>
      </ul>
    </nav>
  </div>
@endisset
