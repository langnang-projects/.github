@extends('admin::layouts.master')

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card mb-2">
            <div class="card-header d-flex align-items-center py-2">
              <h3 class="card-title mr-auto">
                Meta Table
                <small class="text-muted"><em>paging meta data</em></small>
              </h3>

              <form class="form-inline mb-0" name="table">
                <input type="hidden" name="parent" value="{{ request()->input('parent', 0) }}">
                <div class="form-group ml-1 d-none">
                  <select class="form-control form-control-sm" name="module" placeholder="Module" style="width: 120px;">
                    <option value="">--Module--</option>
                    @foreach (\Module::allEnabled() as $moduleName => $moduleObject)
                      <option value="{{ $moduleObject->getAlias() }}" @if (request()->input('module') == $moduleObject->getAlias()) selected @endif>{{ $moduleName }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group ml-1">
                  <input type="text" name="slug" class="form-control form-control-sm" placeholder="--Slug--" value="{{ request()->input('slug') }}" style="width: 120px;">
                </div>
                <div class="form-group ml-1">
                  <input type="text" name="title" class="form-control form-control-sm" placeholder="--Title--" value="{{ request()->input('title') }}" style="width: 120px;">
                </div>
                <div class="form-group ml-1">
                  <select class="form-control form-control-sm" name="type" style="width: 120px;">
                    <option value="">--Type--</option>
                    @foreach (Arr::get($module, 'options.meta.type') as $option)
                      <option value="{{ $option['value'] }}" @if (request()->input('type') == $option['value']) selected @endif>{{ $option['name'] }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group ml-1">
                  <select class="form-control form-control-sm" name="status" style="width: 120px;">
                    <option value="">--Status--</option>
                    @foreach (Arr::get($module, 'options.meta.status') as $option)
                      <option value="{{ $option['value'] }}" @if (request()->input('status') == $option['value']) selected @endif>{{ $option['name'] }}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary form-control form-control-sm ml-1">
                  查询
                </button>
                <a href="metas" class="btn btn-sm btn-secondary form-control form-control-sm ml-1">
                  重置
                </a>
                <div class="btn-group btn-group-sm ml-1" role="group">
                  <button type="button" class="btn btn-info">下载</button>
                  <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu">
                    <button class="dropdown-item">CSV</button>
                    <button class="dropdown-item">Excel</button>
                    <button class="dropdown-item">JSON</button>
                    <div class="dropdown-divider my-1"></div>
                    <button class="dropdown-item">PDF</button>
                    <div class="dropdown-divider my-1"></div>
                    <button class="dropdown-item">SQL</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: calc(100vh - 275px);">
              <table class="table table-sm table-striped table-hover table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th width="14px">#</th>
                    <th>Name</th>
                    <th>Children</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Release At</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($paginator ?? [] as $item)
                    <tr>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="{{ $item['id'] }}">
                        </div>
                      </td>
                      <td><a class="" href="metas/{{ $item['id'] }}">
                          @if (Str::startsWith($item['type'], 'draft-'))
                            <span class="badge badge-secondary">Draft</span>
                          @endif
                          {{ $item['name'] }}
                        </a></td>
                      <td>
                        @if (in_array($item['type'], ['module', 'category']))
                          <a class="" href="metas?parent={{ $item['id'] }}">{{ $item['children_count'] }}</a>
                        @else
                          -
                        @endif
                      </td>
                      <td>{{ $item['type'] }}</td>
                      <td>{{ $item['status'] }}</td>
                      <td>{{ $item['order'] }}</td>
                      <td>{{ $item['created_at'] }}</td>
                      <td>{{ $item['updated_at'] }}</td>
                      <td>{{ $item['release_at'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
            <!-- /.card-body -->
            <div class="card-footer py-2 clearfix d-flex align-items-center">
              <form class="form-inline mb-0 mr-1" action="metas/list" method="get" name="batch-operation">
                <input type="hidden" name="ids" value="">
                <div class="form-check form-check-inline">
                  <input class="form-check-input checkbox-toggle mr-0" type="checkbox">
                  <button type="button" class="btn btn-sm btn-link form-check-label" style="width: 60px;">全选</button>
                </div>
                <div class="form-group mb-0">
                  <select name="operation" class="form-control form-control-sm">
                    <option>选中项：</option>
                    <option value="update">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编辑</option>
                    <option value="copy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;复制</option>
                    <option value="delete">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;删除</option>
                    <option value="remove">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;移动</option>

                    <optgroup label="导出：">
                      <option value="export-json">JSON</option>
                      <option value="export-csv">CSV</option>
                      <option value="export-xlsx">Excel</option>
                      <option value="export-pdf">PDF</option>
                    </optgroup>
                  </select>
                </div>
              </form>
              <form class="form-inline mb-0 mr-1" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-sm">
                  <div class="custom-file" style="width: 160px;">
                    <input type="file" class="custom-file-input" accept=".json,.xlsx,.csv,.md,.txt" name="file">
                    <label class="custom-file-label justify-content-start text-truncate">Choose file...</label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">上传</button>
                  </div>
                </div>
              </form>
              <div class="mr-auto">
                <a type="button" class="btn btn-sm btn-primary" href="metas/create?{{ Arr::query(request()->all()) }}">新增</a>
                <a type="button" class="btn btn-sm btn-warning" href="metas/factory?{{ Arr::query(request()->all()) }}">Factory</a>
                <button type="button" class="btn btn-sm btn-secondary">打印</button>
                <button type="button" class="btn btn-sm btn-secondary">下载</button>
              </div>
              <span class="mr-1"> 共 {{ $paginator->total() }} 条</span>
              <span class="mr-1"> {{ $paginator->currentPage() }}/{{ $paginator->count() }} </span>
              {{ $paginator->onEachSide(2)->withQueryString(['slug', 'title', 'type', 'status'])->links() }}
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@push('scripts')
  <script src="{{ asset('/modules/Admin/Public/master/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.umd.min.js"></script> --}}
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.min.css"> --}}
  <script>
    $(function() {
      $('.checkbox-toggle').click(function() {
        var clicks = $(this).data('clicks')
        if (clicks) {
          //Uncheck all checkboxes
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          //Check all checkboxes
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $('.card-body input[type=\'checkbox\']').prop('checked', !clicks)
        $(this).data('clicks', !clicks)
        $(this).next().data('clicks', !clicks)
        $(this).next().text(clicks ? '全选' : '全不选')
      });
      $('.checkbox-toggle+.btn').click(function() {
        var clicks = $(this).data('clicks')
        //Check all checkboxes
        if (clicks) {
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $('.card-body input[type=\'checkbox\']').prop('checked', !clicks)
        $('.checkbox-toggle').data('clicks', !clicks)
        $('.checkbox-toggle').prop('checked', !clicks)
        $(this).data('clicks', !clicks)
        $(this).text(clicks ? '全选' : '全不选')
      });
      $(document).on('change', 'input[type=file]', function(e) {
        console.log(e, $(this))
      });
      $(document).on('change', 'select[name=\'operation\']', function(e) {
        // console.log(e, $(this))
        // var selectedValues = [];
        // console.log($(".card-body input[type=\'checkbox\']:checked"));
        const ids = [...$(".card-body input[type=\'checkbox\']:checked")].reduce(function(t, v) {
          //   console.log(t, v, $(v).val());
          return [...t, $(v).val()]
        }, []);
        // console.log(ids);
        $('input[name=\'ids\']').val(ids.join("|"));
        // var selectedValueStr = selectedValues.join(", ");
        // console.log("选中的值是: " + selectedValueStr);
        // console.log($('.card-body input[type=\'checkbox\']').val())

        $("form[name='batch-operation']").submit();
      });
    })
  </script>
  <script>
    $(function() {
      bsCustomFileInput.init();
      //   $(document).Toasts('create', {
      //     title: 'Toast Title',
      //     body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      //   })
    })
  </script>
@endpush
