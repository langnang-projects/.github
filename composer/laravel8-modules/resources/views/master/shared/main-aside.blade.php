<form class="my-2" action="{{ url($attributes['alias'] . '/') }}" method="GET">
  <div class="form-group mb-2">
    <div class="input-group input-group-sm mb-0">
      <input type="text" class="form-control form-control-sm" name="title" placeholder="Title">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </div>
</form>

@empty(Arr::get($attributes, 'modules'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      子类
    </div>
    <ul class="list-group list-group-flush d-flex align-items-center">
      @foreach ($children ?? [] as $meta)
        <a class="list-group-item text-truncate py-1 pr-1"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($meta->id ?? $meta->slug)) }}"
          title="{{ $meta->name }}">{{ $meta->name }}</a>
        <a href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-meta/' . ($meta->id ?? $meta->slug)) }}"
          class="bi bi-edit"></a>
      @endforeach
    </ul>
  </div>
@endempty


@empty(Arr::get($attributes, 'categories'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      分类
    </div>
    <ul class="list-group list-group-flush" style="max-height: 329px;overflow: auto;">
      @foreach ($categories ?? [] as $category)
        <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: .9rem;">
          <a class="text-truncate mr-auto"
            href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($category->id ?? $category->slug)) }}"
            title="{{ $category->name }}">{{ $category->name }}</a>
          @if (Auth::check())
            {{-- <a class="bi ml-1 bi-pen" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-meta/' . ($category->id ?? $category->slug)) }}"></a> --}}
          @endif
        </li>
        @foreach ($category['children'] ?? [] as $child)
          <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.2rem;">
            <a class="text-truncate mr-auto"
              href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($child->id ?? $child->slug)) }}"
              title="{{ $child->name }}">{{ $child->name }}</a>
            @if (Auth::check())
              {{-- <a class="bi ml-1 bi-pen" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
            @endif
          </li>
          @foreach ($child['children'] ?? [] as $child_01)
            <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.5rem;">
              <a class="text-truncate mr-auto"
                href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($child_01->id ?? $child_01->slug)) }}"
                title="{{ $child_01->name }}">{{ $child_01->name }}</a>
              @if (Auth::check())
                {{-- <a class="bi ml-1 bi-pen" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
              @endif
            </li>
            @foreach ($child_01['children'] ?? [] as $child_02)
              <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.8rem;">
                <a class="text-truncate mr-auto"
                  href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($child_02->id ?? $child_02->slug)) }}"
                  title="{{ $child_02->name }}">{{ $child_02->name }}</a>
                @if (Auth::check())
                  {{-- <a class="bi ml-1 bi-pen" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
                @endif
              </li>
            @endforeach
          @endforeach
        @endforeach
      @endforeach
    </ul>
    {{-- <x-bootstrap4.tree-group class="list-group-flush" style="max-height: 329px;overflow: auto;" item-class="py-1 pr-1 d-flex align-items-center text-truncate" :data="$categories">

    </x-bootstrap4.tree-group> --}}
  </div>
@endempty


@empty(Arr::get($attributes, 'tags'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      标签
    </div>
    <div class="card-body py-2 pl-2 pr-1" style="max-height: 320px;overflow: auto;">
      @foreach ($tags ?? [] as $tag)
        <a class="badge badge-pill badge-primary text-truncate my-1"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'meta/' . ($tag->id ?? $tag->slug)) }}"
          title="{{ $tag->name }}" style="max-width: 100%;">{{ $tag->name }}</a>
      @endforeach
    </div>
  </div>
@endempty


@empty(Arr::get($attributes, 'latest_contents'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最新
    </div>
    <ul class="list-group list-group-flush">
      @foreach ($latest_contents ?? [] as $latest_content)
        <a class="list-group-item text-truncate py-1  pr-1"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'content/' . ($latest_content->id ?? $latest_content->slug)) }}"
          title="{{ $latest_content->title }}">{{ $latest_content->title }}</a>
      @endforeach
    </ul>
  </div>
@endempty



@empty(Arr::get($attributes, 'hottest_contents'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最热
    </div>
    <ul class="list-group list-group-flush">
      @foreach ($hottest_contents ?? [] as $hottest_content)
        <a class="list-group-item text-truncate py-1 pr-1"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'content/' . ($hottest_content->id ?? $hottest_content->slug)) }}"
          title="{{ $hottest_content->title }}">{{ $hottest_content->title }}</a>
      @endforeach
    </ul>
  </div>
@endempty


@empty(Arr::get($attributes, 'latest_comments'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最新回复
    </div>
    <ul class="list-group list-group-flush">
      @foreach ($latest_comments ?? [] as $latest_comment)
        <a class="list-group-item text-truncate py-1 pr-1"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'content/' . $latest_comment->content_id) }}"
          title="{{ $latest_comment->text }}">{{ $latest_comment->text }}</a>
      @endforeach
    </ul>
  </div>
@endempty
