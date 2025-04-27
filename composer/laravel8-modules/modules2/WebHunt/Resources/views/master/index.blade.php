@extends('master.index')

@section('posts')
  @foreach ($posts ?? [] as $post)
    <div class="card my-2">
      <div class="card-header d-flex align-items-center">
        <img src="{{ $post->ico }}" alt="" height="24px">
        <h5 class="card-title mb-0"> {{ $post->title }}</h5>
      </div>
      <div class="card-body px-3 py-2 h5 mb-0">
        @foreach ($post['text']['groups'] as $groupKey => $group)
          <a href="{{ asset('./webhunt/content/' . $post->id . '-' . $groupKey) }}" class="badge badge-dark">{{ $group['name'] }}</a>
        @endforeach
      </div>
      <div class="card-footer py-2 small d-flex align-items-center">
        <span class="px-2">{{ $post->updated_at }}</span>
        <span class="px-2 mr-auto">{{ $post->user }}</span>
        <a href="{{ url((isset($module) ? $module['alias'] . '/' : 'home/') . 'content/' . ($post->id ?? $post->slug)) }}" class="alert alert-info py-1 mb-0" role="alert">
          <small>阅读更多</small>
        </a>
      </div>
    </div>
  @endforeach
@endsection
