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

            <li class="breadcrumb-item py-1 active" aria-current="page"> {{ $link->title }}
            </li>
            @if (Auth::check())
              {{-- <li class="ml-auto">
                <a class="btn btn-sm btn-warning" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-link/' . ($link->id ?? $link->slug)) }}" role="button">Update</a>
                <a class="btn btn-sm btn-danger" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-link/' . ($link->id ?? $link->slug)) }}" role="button">Delete</a>
              </li> --}}
            @endif
          </ol>
        </nav>
        @isset($link)
          <div class="jumbotron mt-2">
            <h3 class="display-6 d-flex align-items-center">
              <img src="{{ $link->ico }}" class="mr-2" alt="..." style="width: 36px">
              {{ $link->title }}
            </h3>
            <p class="lead">{{ $link->keywords }}</p>
            <hr class="my-2">
            <p>{{ $link->description }}</p>
            <a class="btn btn-primary" href="{{ $link->url }}" role="button" target="_blank">Jump</a>
            @if (Auth::check())
              {{-- <a class="btn btn-warning" href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'update-link/' . ($link->id ?? $link->slug)) }}" role="button">Edit</a> --}}
            @endif
          </div>
          <article>
            @isset($link->text)
              @if (is_string($link->text))
                {!! markdown_to_html($link->text) !!}
              @else
                {{ json_encode($link->text, JSON_UNESCAPED_UNICODE) }}
              @endif
            @endisset
          </article>
        @endempty
      </div>
      <aside class="col-3">
        @include('master.shared.main-aside')
      </aside>
    </div>
  </div>
@endsection
