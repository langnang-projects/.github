@extends($layout)


@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mb-2">
            <div class="card-header">
              <h3 class="card-title">Fixed Header Table</h3>

              <form class="form-inline card-tools float-right">
                <div class="form-group mr-1">
                  <input type="text" name="title" class="form-control form-control-sm" placeholder="Title">
                </div>
                <div class="form-group mr-1">
                  <select class="form-control form-control-sm" name="type">
                    <option selected>Type...</option>
                    <option>...</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-sm btn-default">
                  <i class="fas fa-search"></i>
                </button>

              </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: calc(100vh - 275px);">
              <table class="table table-sm table-striped table-hover table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th width="14px">#</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($moduleTablePaginator ?? [] as $moduleTableDetail)
                    <tr>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="{{ $moduleTableDetail->cid }}">
                        </div>
                      </td>
                      <td><a class="" href="contents/{{ $moduleTableDetail->cid }}">{{ $moduleTableDetail->cid }}</a></td>
                      <td>{{ $moduleTableDetail->title }}</td>
                      <td>{{ $moduleTableDetail->status }}</td>
                      <td>{{ $moduleTableDetail->created_at }}</td>
                      <td>{{ $moduleTableDetail->updated_at }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <div class="card-footer__left float-left">
                <a type="button" class="btn btn-sm btn-info" href="contents/insert">新增</a>
                <button type="button" class="btn btn-sm btn-danger">删除</button>
                <button type="button" class="btn btn-sm btn-secondary">Right</button>
              </div>
              <div class="card-footer__right float-right">
                <ul class="pagination m-0">
                  <li class="page-item">
                    <a class="page-link" href="{{ $moduleTablePaginator->previousPageUrl() }}">
                      <i class="fas fa-angles-left"></i>
                    </a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="{{ $moduleTablePaginator->nextPageUrl() }}">
                      <i class="fas fa-angles-right"></i>
                    </a>
                  </li>
                </ul>
              </div>
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
