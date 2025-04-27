@extends('layouts.master')

@section('content')
  <div class="container">
    <main class="row">
      <div class="col-12 col-lg-9">
        @empty($metas['categories'])
        @else
          @foreach ($metas['categories'] as $meta)
            <div class="card my-2">
              <div class="card-header">
                <h5 class="card-title mb-0">
                  <span class="badge badge-secondary">{{ $meta->status }}</span>
                  {{ $meta->name }}
                </h5>
              </div>
              <div class="card-body px-3 py-2">
              </div>
              <div class="card-footer py-2 small">
                <a href="{{ url((isset($module) ? $module['alias'] . '/' : '') . 'meta/' . ($meta->id ?? $meta->slug)) }}" class="btn btn-sm btn-primary"><small>Go somewhere</small></a>
                {{ $meta->updated_at }}
              </div>
            </div>
          @endforeach
          {{ $metas['categories']->links() }}
        @endempty

      </div>
      <aside class="col-3 d-md-none d-lg-block">
        @include('shared.master.main-aside')
      </aside>
    </main>
  </div>
@endsection
