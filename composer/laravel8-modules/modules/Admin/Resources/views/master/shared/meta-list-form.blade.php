<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <form method="POST" class="row">
      @csrf
      @if (request()->input('operation') == 'delete')
        <div class="col-md-12">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
            entire
            soul, like these sweet mornings of spring which I enjoy with my whole heart.
          </div>
        </div>
      @endif
      <div class="@if (request()->input('operation') == 'remove') col-md-8 @else col-md-12 @endif">
        <div class="card">
          <div class="card-header d-flex align-items-center py-2">
            <h4 class="mb-0 mr-auto">Meta List</h4>
            <div class="">
              {{-- <button type="button" class="btn btn-sm btn-secondary" onclick="$('[name=_action]').val('draft');$('form[name=content-row]').submit()">Draft</button> --}}
              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
              {{-- <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('release');$('form[name=content-row]').submit()">Release</button> --}}
              <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('factory');$('form[name=content-row]').submit()">Factory</button>
            </div>
          </div>
          <ul class="list-group list-group-flush">
            @foreach ($list ?? [] as $index => $item)
              <li class="list-group-item pt-1 pb-0 d-flex align-items-center">
                <div class="form-group mb-0 mr-2 clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" checked="">
                    <label for="checkboxPrimary1">
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <input type="hidden" class="form-control" name='list[{{ $index }}][id]' value="{{ $item['id'] }}">
                    <div class="form-group mb-1">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Slug</span>
                        </div>
                        <input type="text" class="form-control" name='list[{{ $index }}][slug]' value="{{ $item['slug'] }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-1">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Type</span>
                        </div>
                        <select class="form-control" name='list[{{ $index }}][type]'>
                          @foreach (Arr::get($module, 'options.meta.type', []) as $option)
                            <option value="{{ $option['value'] }}" @if ($option['value'] == $item['type']) selected @endif>{{ $option['name'] }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-1">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Status</span>
                        </div>
                        <select class="form-control" name='list[{{ $index }}][status]'>
                          @foreach (Arr::get($module, 'options.meta.status', []) as $option)
                            <option value="{{ $option['value'] }}" @if ($option['value'] == $item['type']) selected @endif>{{ $option['name'] }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-1">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Name</span>
                        </div>

                        <input type="text" class="form-control" name='list[{{ $index }}][name]' value="{{ $item['name'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group mb-1">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Ico</span>
                        </div>
                        <input type="text" class="form-control" name='list[{{ $index }}][ico]' value="{{ $item['ico'] }}">
                      </div>
                    </div>
                  </div>

                </div>
              </li>
            @endforeach
          </ul>
          <div class="card-footer py-2">
            <div class="row">
              <div class="col mr-auto">
                <div class="form-check form-check-inline">
                  <input class="form-check-input checkbox-toggle mr-0" type="checkbox" checked>
                  <button type="button" class="btn btn-sm btn-link form-check-label" style="width: 60px;">全不选</button>
                </div>
              </div>
              <div class="col col-auto">
                {{-- <button type="button" class="btn btn-sm btn-secondary" onclick="$('[name=_action]').val('draft');$('form[name=content-row]').submit()">Draft</button> --}}
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                {{-- <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('release');$('form[name=content-row]').submit()">Release</button> --}}
                <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('factory');$('form[name=content-row]').submit()">Factory</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if (request()->input('operation') == 'remove')
        <div class="col-md-4">
          <div class="card">
            <div class="card-header d-flex align-items-center py-2">
              <h4 class="mb-0 mr-auto">Modules</h4>
              <div class="">
                {{-- <button type="button" class="btn btn-sm btn-secondary" onclick="$('[name=_action]').val('draft');$('form[name=content-row]').submit()">Draft</button> --}}
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                {{-- <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('release');$('form[name=content-row]').submit()">Release</button> --}}
                <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('factory');$('form[name=content-row]').submit()">Factory</button>
              </div>
            </div>
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                <div class="form-check" style="padding-left: .5rem;">
                  <input class="form-check-input" type="radio" name="module" value="0">
                  <label class="form-check-label">Root</label>
                </div>
                @foreach ($modules ?? [] as $meta_module)
                  <div class="form-check" style="padding-left: 1rem;">
                    <input class="form-check-input" type="radio" name="module" value="{{ $meta_module['id'] }}">
                    <label class="form-check-label">{{ $meta_module['name'] }}</label>
                  </div>
                  @foreach ($meta_module['children'] ?? [] as $meta_module_01)
                    <div class="form-check" style="padding-left: 1.5rem;">
                      <input class="form-check-input" type="radio" name="module" value="{{ $meta_module_01['id'] }}">
                      <label class="form-check-label">{{ $meta_module_01['name'] }}</label>
                    </div>
                    @foreach ($meta_module_01['children'] ?? [] as $meta_module_02)
                      <div class="form-check" style="padding-left: 2rem;">
                        <input class="form-check-input" type="radio" name="module" value="{{ $meta_module_02['id'] }}">
                        <label class="form-check-label">{{ $meta_module_02['name'] }}</label>
                      </div>
                    @endforeach
                    @foreach ($meta_module_02['children'] ?? [] as $meta_module_03)
                      <div class="form-check" style="padding-left: 2.5rem;">
                        <input class="form-check-input" type="radio" name="module" value="{{ $meta_module_03['id'] }}">
                        <label class="form-check-label">{{ $meta_module_03['name'] }}</label>
                      </div>
                    @endforeach
                  @endforeach
                @endforeach
              </div>
            </div>
            <div class="card-footer py-2">
              <div class="row">
                <div class="col mr-auto">
                </div>
                <div class="col col-auto">
                  {{-- <button type="button" class="btn btn-sm btn-secondary" onclick="$('[name=_action]').val('draft');$('form[name=content-row]').submit()">Draft</button> --}}
                  <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                  {{-- <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('release');$('form[name=content-row]').submit()">Release</button> --}}
                  <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('factory');$('form[name=content-row]').submit()">Factory</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </form>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@push('scripts')
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
        $('.list-group input[type=\'checkbox\']').prop('checked', !clicks)
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
        $('.list-group input[type=\'checkbox\']').prop('checked', !clicks)
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

    })
  </script>
@endpush
