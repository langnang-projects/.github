@extends($module['slug'] . '::layouts.' . $module['layout'])

@push('styles')
  <style>
    spinner-grow-33 {
      /* animation: .75s linear infinite spinner-grow; */
      animation-delay: .25s
    }
  </style>
@endpush

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row row-cols-2 masonry d-none" data-masonry='{ "itemSelector": ".masonry-item" }'>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 核心架构 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 基础架构 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 前端开发 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 安全相关 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 综合话题 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 核心架构 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 数据库 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
              <div class="col">
                <a class="card my-2" href="artisan/migration">
                  <div class="card-body py-2">
                    数据库迁移
                  </div>
                </a>
              </div>
              <div class="col">
                <a class="card my-2" href="artisan/seeding">
                  <div class="card-body py-2">
                    数据填充
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 模型关联 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 测试相关 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
        <div class="col masonry-item">
          <div class="card">
            <div class="card-header py-2"> 框架拓展 </div>
            <div class="card-body row row-cols-2 px-2 py-0">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <form method="post">
            <div class="card card-primary">
              <div class="card-header d-none">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @csrf
              <div class="card-body bg-dark px-2 d-none">
                <div class="d-flex">
                  <i class="fas fa-layer-group"></i>
                </div>
                {{-- {!! markdown_to_html($commands) !!} --}}
                @foreach ($commands ?? [] as $command)
                  @empty($command['command'])
                  @else
                    <div class="row py-1" style="line-height: 21px;">
                      @if ($command['is_group'])
                        <div class="col text-warning">{!! $command['command'] !!}</div>
                      @elseif($command['is_category'])
                        <div class="col text-warning">{!! $command['command'] !!}</div>
                      @elseif(empty($command['signature']))
                        <div class="col text-white pl-3">{{ $command['description'] }}</div>
                      @else
                        <div class="col col-auto">
                          <button type="button" class="btn btn-link" style="padding: 1px 0;" data-signature="{{ $command['signature'] }}">
                            <i class="bi bi-play-circle-fill"></i></button>
                        </div>
                        <div class="col col-3 text-success">{{ $command['signature'] }}</div>
                        <div class="col text-white">{{ $command['description'] }}</div>
                      @endif
                    </div>
                  @endempty
                @endforeach
              </div>
              <!-- /.card-body -->

              <ul class="list-group list-group-flush">
                @foreach ($commands ?? [] as $command)
                  @empty($command['command'])
                  @else
                    <li class="list-group-item py-0 px-2 bg-dark">
                      <kbd class="d-block" style="line-height: 21px;">
                        @csrf
                        @if ($command['is_group'])
                          <div class="text-warning">{!! $command['command'] !!}</div>
                        @elseif($command['is_category'])
                          <div class="text-warning">{!! $command['command'] !!}</div>
                        @elseif(empty($command['signature']))
                          <div class="text-white pl-3">{{ $command['description'] }}</div>
                        @else
                          <div class="row mb-0">
                            <div class="col col-auto">
                              {{-- <button type="button" class="btn btn-link" style="padding: 1px 0;" data-toggle="modal"
                                data-target="#exampleModal" data-signature="{{ $command['signature'] }}">
                                <i class="bi bi-play-circle-fill"></i>
                              </button> --}}
                              <button type="button" class="btn btn-link" style="padding: 1px 0;" data-signature="{{ trim($command['signature']) }}">
                                <i class="bi bi-play-circle-fill"></i>
                              </button>
                            </div>
                            <div class="col col-auto text-success px-0" style="width: 220px;">
                              <a class="btn btn-link btn-sm p-0 text-success" data-toggle="collapse" href="#collapse-{{ str_replace(':', '-', trim($command['signature'])) }}" role="button" aria-expanded="false" aria-controls="collapse-{{ str_replace(':', '-', trim($command['signature'])) }}" style="line-height: 19px;">
                                {{ trim($command['signature']) }}
                              </a>
                              <input type="hidden" name="signature" value="{{ trim($command['signature']) }}">
                            </div>
                            <div class="col col-1" style="color: white;">
                              <input type="text" name="args[]" value="@if (request()->input('signature') == $command['signature']) echo request()->input('args.0'); @endif" style="width: 100%;background: transparent;border-bottom: 1px solid white;line-height: 17px;color: white;">
                            </div>
                            <div class="col col-1" style="color: white;">
                              <input type="text" name="args[]" value="" style="width: 100%;background: transparent;border-bottom: 1px solid white;line-height: 17px;color: white;">
                            </div>
                            <div class="col text-white">{{ $command['description'] }}</div>
                          </div>
                          <div class="row collapse" id="collapse-{{ str_replace(':', '-', trim($command['signature'])) }}">
                            <div class="col col-auto" style="width: 33px;"> </div>
                            <div class="col col-auto" data-name="status" style="width: 33px;"> </div>
                            <div class="col text-primary" style="width: 0;">
                              <p class="mb-0" data-name="command"></p>
                              <div class="pl-3 text-info" data-name="response"></div>
                            </div>
                          </div>
                        @endif

                      </kbd>
                    </li>
                  @endempty
                @endforeach
              </ul>

              <div class="card-footer d-none">
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>
  <section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header py-2">
            <kbd class="modal-title" id="exampleModalLabel">
              New message</kbd>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body py-2 bg-dark">
            <div class="d-flex justify-content-center">
              <div class="spinner-grow spinner-grow-sm text-info mx-2" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow spinner-grow-sm text-primary mx-2" style="animation-delay: .15s;" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow spinner-grow-sm text-warning mx-2" style="animation-delay: .3s;" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow spinner-grow-sm text-success mx-2" style="animation-delay: .45s;" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow spinner-grow-sm text-danger mx-2" style="animation-delay: .6s;" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            {{-- <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Message:</label>
                <textarea class="form-control" id="message-text"></textarea>
              </div>
            </form> --}}
          </div>
          <div class="modal-footer py-2">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    $('[data-signature]').on('click', function(event) {
      console.log(event);
      console.log(event.currentTarget);
      var button = $(event.currentTarget);
      var signature = button.data('signature') // Extract info from data-* attributes
      var parent = button.parent().parent();
      var inputs = parent.find('[name="args[]"]');
      var args = [];
      for (let i = 0; i < inputs.length; i++) {
        let val = inputs[i].value.trim()
        if (val) {
          args.push(val);
        }
        // args += ' ' + inputs[i].value;
      }
      //   console.log(inputs)
      //   console.log(parent.find('[name="args[]"]').map((ind, el) => ind))
      //   console.log(parent.find('[name="args[]"]').map((ind, el) => el))
      //   console.log(parent.find('[name="args[]"]').map((ind, el) => el.value))
      //   console.log(parent.find('[name="args[]"]').reduce((tal, ind, el) => tal + ' ' + el.value, ''))
      //   console.log(args)
      //   console.log(button);
      //   console.log(parent);
      var parentNext = button.parent().parent().next();
      //   console.log(parentNext);
      parentNext.find('[data-name="status"]').html(
        `<div class="spinner-grow spinner-grow-sm text-primary" role="status"> </div>`);
      parentNext.find('[data-name="command"]').text(
        `php artisan ` + signature + ' ' + args.join(' '));
      parentNext.addClass('show');
      //   var button = $(event) // Button that triggered the modal
      //   var button = $(event.relatedTarget) // Button that triggered the modal
      //   console.log(button);
      axios({
        url: "/api/artisan",
        method: "post",
        data: {
          signature,
          args,
        },
      }).then(res => {
        // console.log(modal, res);
        // modal.find('.modal-body').text(res)
        parentNext.find('[data-name="status"]').html(
          `<i class="bi bi-check-lg text-success" style="font-size: 20px;"></i>`);
        parentNext.find('[data-name="response"]').removeClass('text-danger');
        parentNext.find('[data-name="response"]').addClass('text-info');
        parentNext.find('[data-name="response"]').html(res.output.split('\n').map(v =>
          `<p class="mb-1">${v.replace(/ /g,'&nbsp;')}</p>`).join(''));
      }).catch(err => {
        console.log(err);
        parentNext.find('[data-name="status"]').html(
          `<i class="bi bi-x-lg text-danger" style="font-size: 20px;"></i>`);
        parentNext.find('[data-name="response"]').removeClass('text-info');
        parentNext.find('[data-name="response"]').addClass('text-danger');
        parentNext.find('[data-name="response"]').html(err.message.split('\n').map(v =>
          `<p class="mb-1 text-wrap">${v.replace(/ /g,'&nbsp;')}</p>`).join(''));
      });
    })

    $('#exampleModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var signature = button.data('signature') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('php artisan ' + signature)
      modal.find('.modal-body input').val(signature)
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
@endpush
