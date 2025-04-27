<div class="modal fade" id="{{ $module ? $module . '-' : '' }}content-item-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">New Content</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="_target" value="">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="meta_ids" value="">
        <input type="hidden" name="parent" value="">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="slug">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ico</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="ico">
          </div>
        </div>

        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Type</legend>
          <div class="col-sm-10">
            <div class="row">
              @foreach ($typeOption ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" value="{{ $option['value'] }}">
                    <label class="form-check-label">
                      {{ $option['nameCn'] }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </fieldset>
        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Status</legend>
          <div class="col-sm-10">
            <div class="row">
              @foreach ($statusOption ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="{{ $option['value'] }}">
                    <label class="form-check-label">
                      {{ $option['nameCn'] }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </fieldset>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" rows="2"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Text</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="text" rows="4"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <div class="alert alert-danger my-0 d-none" name="delete-alert" role="alert" style="flex-grow: 1">
          确定要删除吗？
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </form>
  </div>
</div>


@push('script')
  <script></script>
@endpush
