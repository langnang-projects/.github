@extends('layouts.master', ['hideFooter' => true])

@section('content')
  <div class="container-fluid px-2">
    <div class="row">
      <nav class="col-lg-2 d-md-none d-lg-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-2">
          <ul class="nav flex-column">
            @include('webnav::shared.master.nav-item', ['module' => $module['alias'], 'metas' => $meta['children'] ?? [], 'mids' => Arr::get($module, 'meta.id')])
            @auth
              <li class="nav-item text-center" style="width: 100%;">
                <a class="nav-link" href="{{ asset('./meta/create-item?' . request()->query()) }}" style="font-size: 21px;">
                  <i class="bi bi-plus-circle"></i>
                </a>
              </li>
            @endauth
          </ul>

        </div>
      </nav>
      <main role="main" class="ml-sm-auto col-lg-10">
        <div class="" style="min-height: calc(100vh - 132px)">
          @foreach ($meta['children'] ?? [] as $meta)
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
              <h1 class="h4" id="{{ $meta->mid ?? $meta->slug }}"><i class="bi bi-tag"></i> {{ $meta->name }}</h1>
              <div class="btn-toolbar mb-2 mb-md-0 d-none">
                <div class="btn-group mr-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                  <span data-feather="calendar"></span>
                  This week
                </button>
              </div>
            </div>

            <div class="row row-cols-4">
              @foreach ($meta->contents ?? [] as $content)
                <div class="col my-2 px-2">
                  <div class="card">
                    <div class="card-body">
                      <div class="media">
                        <img src="{{ $content->ico }}" class="align-self-center mr-2" width="32px" height="32px" alt="...">
                        <div class="media-body">
                          <h5 class="card-title text-truncate" title="{{ $content->title }}">{{ $content->title }}</h5>

                        </div>
                      </div>
                      <p class="card-text text-truncate" style="display: -webkit-box;white-space: unset;-webkit-line-clamp: 3;-webkit-box-orient: vertical;height: 65px;">{{ $content->description . $content->description . $content->description . $content->description . $content->description }}</p>
                      <p class="mb-0 flex justify-content-end">
                        <a href="#" class="btn btn-sm btn-outline-warning ml-1" data-toggle="modal" data-target="#{{ $module['alias'] }}-content-item-modal" data-method="update_content_item" data-mids="{{ Arr::get($module, 'meta.mid') . '-' . $meta->mid }}" data-cids="{{ $content->cid }}">编辑</a>
                        <a href="#" class="btn btn-sm btn-outline-danger ml-1 mr-auto" data-toggle="modal" data-target="#{{ $module['alias'] }}-content-item-modal" data-method="delete_content_item" data-mids="{{ Arr::get($module, 'meta.mid') . '-' . $meta->mid }}" data-cids="{{ $content->cid }}">删除</a>
                        <a href="#" class="btn btn-sm btn-outline-primary ml-1">详情</a>
                        <a href="#" class="btn btn-sm btn-outline-primary ml-1">跳转</a>
                      </p>
                    </div>
                  </div>
                </div>
              @endforeach
              @auth
                <div class="col my-2 px-2">
                  <div class="card">
                    <a class="card-body d-flex justify-content-center align-items-center" href="#" data-toggle="modal" data-target="#{{ $module['alias'] }}-content-item-modal" data-method="insert_content_item" data-mids="{{ Arr::get($module, 'meta.mid') . '-' . $meta->mid }}" style="height: 190px; font-size: 48px;">
                      <i class="bi bi-plus-circle"></i>
                    </a>
                  </div>
                </div>
              @endauth
            </div>
          @endforeach
        </div>
        <div class="row">
          @include('shared.master.footer')
        </div>
      </main>

    </div>
  </div>
  @auth
    {{-- <x-master.meta-item-modal :typeOption="{{ Arr::get($module, 'option.meta.type') }}" /> --}}
    <x-master.meta-item-modal :module="$module['alias']" :typeOption="Arr::get($module, 'option.meta.type')" :statusOption="Arr::get($module, 'option.meta.status')" />
    <x-master.content-item-modal :module="$module['alias']" :typeOption="Arr::get($module, 'option.content.type')" :statusOption="Arr::get($module, 'option.content.status')" />
  @endauth
@endsection

@push('scripts')
  {{-- <script crossorigin="anonymous" src="https://unpkg.com/feather-icons@4.29.2/dist/feather.min.js"></script> --}}
  {{-- <script crossorigin="anonymous" src="https://unpkg.com/chart.js@4.4.7/dist/chart.umd.js"></script> --}}
  <script>
    // $('#insertCategory').on('click', function($event) {
    //   console.log(`#insertCategory.onclick`, $event);
    //   $('.popover-dismiss').popover({
    //     trigger: 'focus'
    //   })
    // })
  </script>
@endpush
