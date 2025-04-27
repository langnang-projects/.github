@extends($module['slug'] . '::layouts.' . $module['layout'])

@push('styles')
  <style>
    .note-editor.card {
      margin-bottom: 0;
    }
  </style>
@endpush

@section('content')
  <section class="content">
    <div class="container-fluid">
      <form class="row" method="post" name="content">
        @csrf
        <div class="col-8">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Content</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control form-control-sm" name='title' value="{{ $content['title'] ?? '' }}">
              </div>
              <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control form-control-sm" name='slug' value="{{ $content['slug'] ?? '' }}">
              </div>
              <div class="form-group">
                <label>ICO</label>
                <input type="text" class="form-control form-control-sm" name='ico' value="{{ $content['ico'] ?? '' }}">
              </div>
              <div class="form-group">
                <label>Type</label>
                <input type="text" class="form-control form-control-sm" name='type' value="{{ $content['type'] ?? '' }}">
              </div>
              <div class="form-group">
                <label>Status</label>
                <input type="text" class="form-control form-control-sm" name='status' value="{{ $content['status'] ?? '' }}">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="" class="form-control form-control-sm" cols="30" rows="3">{{ $content['description'] ?? '' }}</textarea>
              </div>
              <div class="form-group d-none">
                <label>Text</label>
                <textarea name="text" id="" class="form-control form-control-sm" cols="30" rows="5">{!! $content['text'] ?? '' !!}</textarea>
              </div>
            </div>

            <!-- /.card-body -->

            <div class="card-footer">
              <div class="row">
                <div class="col mr-auto">
                  <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                  <button type="button" class="btn btn-sm btn-warning">Release</button>
                </div>
                <div class="col col-auto">
                  <button type="button" class="btn btn-sm btn-secondary">Draft</button>
                  <button type="button" class="btn btn-sm btn-danger">Faker</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title"> Text </h3>
            </div>
            <div class="card-body p-1">
              <div class="form-group mb-0">
                <div id="summernote" style="height: 10rem;"> {!! $content['text'] ?? '' !!} </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col mr-auto">
                  <button type="button" class="btn btn-sm btn-primary" onclick="$('[name=text]').text($('#summernote').summernote('code').trim());$('form[name=content]').submit()">Submit</button>
                  <button type="button" class="btn btn-sm btn-warning">Release</button>
                </div>
                <div class="col col-auto">
                  <button type="button" class="btn btn-sm btn-secondary">Draft</button>
                  <button type="button" class="btn btn-sm btn-danger">Faker</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-outline card-primary d-none">
            <div class="card-header">
              <h3 class="card-title"> Text </h3>
            </div>
            <div class="card-body p-1">
              <div class="form-group mb-0">
                <textarea id="codeMirror" class="form-control form-control-sm" rows="3">{!! $content['text'] ?? '' !!}</textarea>

              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col mr-auto">
                  <button type="button" class="btn btn-sm btn-primary" onclick="console.log($('#summernote').summernote('code'))">Submit</button>
                  <button type="button" class="btn btn-sm btn-warning">Release</button>
                </div>
                <div class="col col-auto">
                  <button type="button" class="btn btn-sm btn-secondary">Draft</button>
                  <button type="button" class="btn btn-sm btn-danger">Faker</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                  <h3 class="card-title">Fields</h3>
                </div>
                <div class="col-auto ml-auto">
                  <button class="btn btn-primary" type="button" name="insert-field">
                    <i class="bi bi-patch-plus-fill "></i>
                  </button>
                </div>
              </div>

            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              @foreach ($content['fields'] ?? [] as $field)
                <div class="form-row">
                  <div class="col">
                    <div class="row">
                      <input type="hidden" name="fields[{{ $loop->index }}][action]" value="update">
                      <div class="form-group form-group-sm col-md-3">
                        <input type="text" class="form-control form-control-sm" name="fields[{{ $loop->index }}][name]" placeholder="Name" value="{{ $field['name'] }}" readonly>
                      </div>
                      <div class="form-group form-group-sm col-md-2">
                        <select class="form-control form-control-sm" name="fields[{{ $loop->index }}][type]" placeholder="Type" readonly>
                          <option value="str" @if ($field['type'] == 'str') selected @endif>str</option>
                          <option value="int" @if ($field['type'] == 'int') selected @endif>int</option>
                          <option value="float" @if ($field['type'] == 'float') selected @endif>float</option>
                          <option value="text" @if ($field['type'] == 'text') selected @endif>text</option>
                          <option value="object" @if ($field['type'] == 'object') selected @endif>object</option>
                        </select>
                      </div>
                      <div class="form-group form-group-sm col-md-7">
                        @switch($field['type'])
                          @case('text')
                          @case('object')
                            <textarea class="form-control form-control-sm" name="fields[{{ $loop->index }}][value]" placeholder="Value" readonly rows="1">{{ $field[$field['type']] ?? '' }}</textarea>
                          @break

                          @default
                            <input type="text" class="form-control form-control-sm" name="fields[{{ $loop->index }}][value]" placeholder="Value" value="{{ $field[$field['type']] ?? '' }}" readonly>
                          @break
                        @endswitch
                      </div>
                    </div>
                  </div>
                  <div class="col-auto ml-auto">
                    <div class="btn-group form-control-sm p-0" role="group" aria-label="Basic example">
                      <button class="btn btn-primary" type="button" name="update-field" data-toggle="modal" data-target="#exampleModal">
                        <i class="bi bi-pencil-fill"></i>
                      </button>
                      <button class="btn btn-danger" type="button" name="delete-field">
                        <i class="bi bi-patch-minus-fill"></i>
                      </button>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">

            </div>

            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tags</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">

            </div>

            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Links</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">

            </div>

            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </form>

    </div>
    <div class="d-none">
      <div id="editor">
        {{ $content['text'] ?? '' }}
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
@endsection


@push('scripts')
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
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirror"), {
        mode: "markdown",
        theme: "monokai"
      });
    })

    // $(document).ready(() => {
    //   ckeditor5.ClassicEditor
    //     .create(document.querySelector('#editor'), {
    //       toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    //       heading: {
    //         options: [{
    //             model: 'paragraph',
    //             title: 'Paragraph',
    //             class: 'ck-heading_paragraph'
    //           },
    //           {
    //             model: 'heading1',
    //             view: 'h1',
    //             title: 'Heading 1',
    //             class: 'ck-heading_heading1'
    //           },
    //           {
    //             model: 'heading2',
    //             view: 'h2',
    //             title: 'Heading 2',
    //             class: 'ck-heading_heading2'
    //           }
    //         ]
    //       }
    //     })
    //     .catch(error => {
    //       console.error(error);
    //     });
    // })
  </script>
@endpush
