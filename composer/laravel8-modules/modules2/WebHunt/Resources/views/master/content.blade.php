@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-9">
        @isset($content)
          <div class="jumbotron mt-2">
            <h3 class="display-6">{{ Arr::get($content, 'title') }}</h3>
            <p class="lead">{{ $content->subtitle }}</p>
            <hr class="my-2">
            <p>{{ $content->description }}</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
          </div>
          <article>
            @if (is_string($content->text))
              {!! markdown_to_html($content->text) !!}
            @else
              {{ json_encode($content->text, JSON_UNESCAPED_UNICODE) }}
            @endif
          </article>
        @endempty
        <div class="row row-cols-4">
          @foreach ($hunt_contents as $hunt_content)
            <div class="col">
              <div class="card">
                <img src="{{ Arr::get($hunt_content, 'ico') }}" class="card-img-top" alt="...">
                <div class="card-body p-2">
                  <h5 class="card-title">{{ Arr::get($hunt_content, 'title') }}</h5>
                  <small class="card-text">{!! Arr::get($hunt_content, 'description') !!}</small>
                </div>
              </div>
            </div>
          @endforeach
          <div class="col-12">
            {{ $hunt_contents->links() }}
          </div>
        </div>
      </div>
      <aside class="col-3">
        @include('shared.master.main-aside')
      </aside>
    </div>
  </div>
@endsection
