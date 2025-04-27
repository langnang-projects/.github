@extends($module['slug'] . '::layouts.' . $module['layout'])


@section('content')
  <section class="content">
    <div class="container-fluid">
      @empty($columns)
        <div class="card">
          <div class="card-header"> 数据库: {{ env('DB_DATABASE') }} </div>
          <div class="card-body"></div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col"> 名 <span class="sr-only">TABLE_NAME</span> </th>
                <th scope="col"> 自动递增值 <span class="sr-only">AUTO_INCREMENT</span> </th>
                <th scope="col"> 修改日期 <span class="sr-only">UPDATE_TIME</span> </th>
                <th scope="col"> 数据长度 <span class="sr-only">DATA_LENGTH</span> </th>
                <th scope="col"> 引擎 <span class="sr-only">ENGINE</span> </th>
                <th scope="col"> 行 <span class="sr-only">TABLE_ROWS</span> </th>
                <th scope="col"> 注释 <span class="sr-only">TABLE_COMMENT</span> </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tables as $table)
                <tr>
                  <th scope="row"><a href="database/{{ $table->TABLE_NAME }}">{{ $table->TABLE_NAME }}</a></th>
                  <td>{{ $table->AUTO_INCREMENT }}</td>
                  <td>{{ $table->UPDATE_TIME }}</td>
                  <td>{{ $table->DATA_LENGTH }}</td>
                  <td>{{ $table->ENGINE }}</td>
                  <td>{{ $table->TABLE_ROWS }}</td>
                  <td>{{ $table->TABLE_COMMENT }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      @else
        <div class="card">
          <div class="card-header"> 数据库: {{ env('DB_DATABASE') }} </div>
          <div class="card-body"></div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col"> 名 <span class="sr-only">COLUMN_NAME</span> </th>
                <th scope="col"> 类型 <span class="sr-only">DATA_TYPE</span> </th>
                <th scope="col"> 长度<span class="sr-only">CHARACTER_MAXIMUM_LENGTH</span> </th>
                <th scope="col"> 不是 null <span class="sr-only">IS_NULLABLE</span> </th>
                <th scope="col"> 键 <span class="sr-only">COLUMN_KEY</span> </th>
                <th scope="col"> 默认值 <span class="sr-only">COLUMN_DEFAULT</span> </th>
                <th scope="col"> 注释 <span class="sr-only">COLUMN_COMMENT</span> </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($columns as $column)
                <tr>
                  <td class="py-2">{{ $column->COLUMN_NAME }}</td>
                  <td class="py-2">{{ $column->DATA_TYPE }}</td>
                  <td class="py-2">{{ $column->CHARACTER_MAXIMUM_LENGTH }}</td>
                  <td class="py-2">{{ $column->IS_NULLABLE }}</td>
                  <td class="py-2">{{ $column->COLUMN_KEY }}</td>
                  <td class="py-2">{{ $column->COLUMN_DEFAULT }}</td>
                  <td class="py-2">{{ $column->COLUMN_COMMENT }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      @endempty
    </div>
  </section>
@endsection

@push('scripts')
  <script></script>
@endpush
