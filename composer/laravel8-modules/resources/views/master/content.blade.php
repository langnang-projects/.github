@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-9">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mt-2 py-1">
            <li class="breadcrumb-item py-1"><a
                href="{{ url(isset($attributes) ? $attributes['alias'] . '/' : 'home/') }}">{{ Arr::get($attributes, 'alias', 'Home') }}</a>
            </li>

            <li class="breadcrumb-item py-1 active" aria-current="page"> {{ $content->title }}
            </li>
            @if (Auth::check())
              {{-- <li class="ml-auto">
                <a class="btn btn-sm btn-warning" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-content/' . ($content->id ?? $content->slug)) }}" role="button">Update</a>
                <a class="btn btn-sm btn-danger" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-content/' . ($content->id ?? $content->slug)) }}" role="button">Delete</a>
              </li> --}}
            @endif
          </ol>
        </nav>
        @isset($content)
          <div class="jumbotron mt-2">
            <h3 class="display-6">{{ $content->title }}</h3>
            <p class="lead">{{ $content->subtitle }}</p>
            <hr class="my-2">
            <section class="markdown">
              {!! markdown_to_html($content->description) !!}
            </section>
            <a class="btn btn-primary" href="#" role="button">Learn more</a>
            @if (Auth::check())
              {{-- <a class="btn btn-warning" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-content/' . ($content->id ?? $content->slug)) }}" role="button">Edit</a> --}}
            @endif
          </div>
          <section class="markdown">
            @isset($content->text)
              @if (is_string($content->text))
                {!! markdown_to_html($content->text) !!}
              @else
                {{ json_encode($content->text, JSON_UNESCAPED_UNICODE) }}
              @endif
            @endisset
          </section>
        @endempty
      </div>
      <aside class="col-3">
        @include('master.shared.main-aside')
      </aside>
    </div>
  </div>
@endsection
