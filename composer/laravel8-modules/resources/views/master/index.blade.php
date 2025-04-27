@extends('layouts.master')

@section('content')
  <div class="container">
    <main class="row">
      <div class="col-12 col-lg-9">
        @isset($meta)
          <div class="alert alert-warning alert-dismissible fade show my-2" role="alert">
            <strong>{{ Arr::get($options, 'meta.type.' . $meta->type . '.nameCn', $meta->type) }}:</strong>
            {{ $meta->name }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endisset
        @empty($posts)
        @else
          @section('posts')
            @foreach ($posts as $post)
              <div
                class="card my-2 @switch($post->status) @case('public') border-secondary @case('publish') border-primary @break @case('protected') border-warning @break @case('private') border-danger @break @default @break @endswitch">
                <div class="card-header d-flex align-items-center">
                  <i class="bi bi-circle-fill mr-2 @switch($post->status) @case('public') text-secondary @case('publish') text-primary @break @case('protected') text-warning @break @case('private') text-danger @break @default @break @endswitch"
                    data-toggle="tooltip" data-placement="right" title="{{ $post->status }}" style="margin-left: -.5rem;"></i>
                  <h5 class="card-title mb-0 text-truncate mr-auto">
                    {{ $post->title }}
                  </h5>
                  <span
                    class="badge text-capitalize @switch($post->status) @case('public') badge-secondary @case('publish') badge-primary @break @case('protected') badge-warning @break @case('private') badge-danger @break @default @break @endswitch">{{ $post->status }}</span>
                  {{-- <button type="button" class="btn btn-sm mx-1 btn-primary">Primary</button>
                <button type="button" class="btn btn-sm mx-1 btn-secondary">Secondary</button>
                <button type="button" class="btn btn-sm mx-1 btn-success">Success</button>
                <button type="button" class="btn btn-sm mx-1 btn-danger">删除</button>
                <button type="button" class="btn btn-sm mx-1 btn-warning">编辑</button>
                <button type="button" class="btn btn-sm mx-1 btn-info">Info</button>
                <button type="button" class="btn btn-sm mx-1 btn-dark">Dark</button> --}}
                </div>
                <div class="card-body px-3 py-2">
                  <section class="markdown">
                    {!! markdown_to_html($post->description) !!}
                  </section>
                </div>
                <div class="card-footer py-2 small d-flex align-items-center">
                  <span class="px-2">{{ $post->updated_at }}</span>
                  <span class="px-2 mr-auto">{{ Arr::get($post, 'user.name', $post['user_id']) }}</span>
                  @if (Auth::check())
                    {{-- <button type="button" class="btn btn-sm mx-1 btn-primary">Primary</button>
                <button type="button" class="btn btn-sm mx-1 btn-secondary">Secondary</button>
                <button type="button" class="btn btn-sm mx-1 btn-success">Success</button> --}}
                    {{-- <a href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-content/' . ($post->id ?? $post->slug)) }}" role="button" class="btn btn-sm mx-1 btn-warning">编辑</a> --}}
                    {{-- <button type="button" class="btn btn-sm mx-1 btn-info">Info</button>
                <button type="button" class="btn btn-sm mx-1 btn-dark">Dark</button> --}}
                  @endif
                  <a href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'content/' . ($post->id ?? $post->slug)) }}"
                    class="alert alert-info py-1 mb-0 ml-1" role="alert">
                    <small>阅读更多</small>
                  </a>
                </div>
              </div>
            @endforeach
          @endsection
          {{ $posts->withQueryString(['slug', 'title', 'type', 'status'])->links() }}
        @endempty

      </div>
      <aside class="col-3 d-md-none d-lg-block">
        @include('master.shared.main-aside')
      </aside>
    </main>

    @empty(Arr::get($attributes, 'links'))
    @else
      <main-links class="row">
        <div class="col">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h6 class="card-title mb-0">关联链接</h6>
            </div>
            <div class="card-body py-1">
              <ul class="list-inline row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 mb-0">
                @foreach ($links ?? [] as $link)
                  <li class="list-inline-item col mr-0 my-1 d-flex align-items-center">
                    <img class="mr-1" src="{{ $link->ico }}" alt="" height="20px">
                    <a class="text-truncate mr-auto"
                      href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'link/' . ($link->id ?? $link->slug)) }}">
                      <small>{{ $link->title }}</small></a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </main-links>
    @endempty
  </div>
@endsection
