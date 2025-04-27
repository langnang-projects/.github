<section class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">
        <form method="post" enctype="multipart/form-data" name="content-row">
          @csrf
          <input type="hidden" name="_action" value="{{ old('_action') }}">
          <div class="card card-outline card-primary">
            <div class="card-header py-2">
              <h3 class="card-title">Meta Row</h3>
            </div>
            <div class="card-body pt-3 pb-0">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Name</span>
                    </div>
                    <input type="text" class="form-control" name='name' placeholder="--Name--" value="{{ old('name', $item['name']) }}"required>
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Slug</span>
                    </div>
                    <input type="text" class="form-control" name='slug' placeholder="--Slug--" value="{{ $item['slug'] ?? '' }}">
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Module</span>
                    </div>
                    <select class="form-control" name='module'>
                      <option value="">--Module--</option>
                      @foreach (Module::all() ?? [] as $moduleName => $moduleObject)
                        <option value="{{ $moduleObject->getAlias() }}" @if ($moduleObject->getAlias() == old('module', $item['module'])) selected @endif>{{ $moduleName }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-4">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Ico</span>
                    </div>
                    <input type="text" class="form-control" name='ico' placeholder="--Ico--" value="{{ $item['ico'] ?? '' }}">
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Type</span>
                    </div>
                    <select class="form-control" name='type'>
                      <option value="">--Type--</option>
                      @foreach (Arr::get($module, 'options.meta.type', []) as $option)
                        <option value="{{ $option['value'] }}" @if ($option['value'] == old('type', $item['type'])) selected @endif>{{ $option['name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control" name='status'>
                      <option value="">--Status--</option>
                      @foreach (Arr::get($module, 'options.meta.status', []) as $option)
                        <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif>{{ $option['name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Order</span>
                    </div>
                    <input type="number" min="0" max="99" class="form-control" name='order' placeholder="--Order--" value="{{ $item['order'] ?? 0 }}">
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Description</span>
                    </div>
                    <textarea name="description" class="form-control" rows="1">{{ $item['description'] ?? '' }}</textarea>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" accept=".json,.xlsx,.csv,.md,.txt" name="file">
                      <label class="custom-file-label">Choose file...</label>
                    </div>
                  </div>
                </div>
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
        </form>
      </div>
      <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title">Dropzone.js <small><em>jQuery File Upload</em> like look</small></h3>
          </div>
          <div class="card-body">
            <div id="actions" class="row">
              <div class="col-lg-6">
                <div class="btn-group w-100">
                  <span class="btn btn-success col fileinput-button">
                    <i class="fas fa-plus"></i>
                    <span>Add files</span>
                  </span>
                  <button type="submit" class="btn btn-primary col start">
                    <i class="fas fa-upload"></i>
                    <span>Start upload</span>
                  </button>
                  <button type="reset" class="btn btn-warning col cancel">
                    <i class="fas fa-times-circle"></i>
                    <span>Cancel upload</span>
                  </button>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
                <div class="fileupload-process w-100">
                  <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table table-striped files" id="previews">
              <div id="template" class="row mt-2">
                <div class="col-auto">
                  <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                </div>
                <div class="col d-flex align-items-center">
                  <p class="mb-0">
                    <span class="lead" data-dz-name></span>
                    (<span data-dz-size></span>)
                  </p>
                  <strong class="error text-danger" data-dz-errormessage></strong>
                </div>
                <div class="col-4 d-flex align-items-center">
                  <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                  </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                  <div class="btn-group">
                    <button class="btn btn-primary start">
                      <i class="fas fa-upload"></i>
                      <span>Start</span>
                    </button>
                    <button data-dz-remove class="btn btn-warning cancel">
                      <i class="fas fa-times-circle"></i>
                      <span>Cancel</span>
                    </button>
                    <button data-dz-remove class="btn btn-danger delete">
                      <i class="fas fa-trash"></i>
                      <span>Delete</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            Visit <a target="_blank" href="https://www.dropzonejs.com">dropzone.js documentation</a> for more examples and information about the plugin.
          </div>
        </div>
        <!-- /.card -->
      </div>

      @if (isset($item['id']) && $item->type == 'module')
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Modules</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['modules'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Branches</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['branches'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Categories</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['categories'] ?? [] as $item_child)
                  <div class="form-check" style="padding-left: 1rem;">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                  @foreach ($item_child['children'] ?? [] as $item_child_02)
                    <div class="form-check" style="padding-left: 1.5rem;">
                      <input class="form-check-input" type="checkbox" disabled>
                      <label class="form-check-label">{{ $item_child_02['name'] }}</label>
                    </div>
                    @foreach ($item_child_02['children'] ?? [] as $item_child_03)
                      <div class="form-check" style="padding-left: 2rem;">
                        <input class="form-check-input" type="checkbox" disabled>
                        <label class="form-check-label">{{ $item_child_03['name'] }}</label>
                      </div>
                    @endforeach
                  @endforeach
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>

          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Tags</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['tags'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
      @endif

    </div>

  </div>
</section>

<section>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label for="">Type</label>
              <input type="text" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label for="">Value</label>
              <textarea type="text" class="form-control form-control-sm"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


</section>


@push('scripts')
  <script src="{{ asset('/modules/Admin/Public/master/plugins/dropzone/min/dropzone.min.js') }}"></script>
  <script src="{{ asset('/modules/Admin/Public/master/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.umd.min.js"></script> --}}
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.min.css"> --}}
  <script>
    $(document).on('click', '[name="insert-field"]', function(e) {
      console.log(e, $(this))
    })
    $(document).on('click', '[name="delete-field"]', function(e) {
      console.log(e, $(this))
    })
    $('#exampleModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var field = button.parents('.form-row')
      var field_name = field.find('[name]').val();
      var field_type = field.find('[name]').val();
      var field_value = field.find('[name]').val();
      console.log(parent)
      //   var signature = button.data('signature') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      //   var modal = $(this)
      //   modal.find('.modal-title').text('php artisan ' + signature)
      //   modal.find('.modal-body input').val(signature)
      //   axios({
      //     url: "/api/artisan",
      //     method: "post",
      //     data: {
      //       signature,
      //     },
      //   }).then(res => {
      //     console.log(modal, res);
      //     modal.find('.modal-body').text(res)
      //   });
    })
  </script>
  <script>
    $(function() {
      // DropzoneJS Demo Code Start
      Dropzone.autoDiscover = false

      // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
      var previewNode = document.querySelector("#template")
      previewNode.id = ""
      var previewTemplate = previewNode.parentNode.innerHTML
      previewNode.parentNode.removeChild(previewNode)

      var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "import/{{ $item->id }}", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
      })

      myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
          myDropzone.enqueueFile(file)
        }
      })

      // Update the total progress bar
      myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
      })

      myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
      })

      // Hide the total progress bar when nothing's uploading anymore
      myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
      })

      // Setup the buttons for all transfers
      // The "add files" button doesn't need to be setup because the config
      // `clickable` has already been specified.
      document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
      }
      document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
      }

    })
  </script>
  <script>
    $(function() {
      bsCustomFileInput.init();
    })
  </script>
@endpush
