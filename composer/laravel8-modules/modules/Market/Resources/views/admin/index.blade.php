<!-- Main content -->
<section class="content">
  <div class="container-fluid">


    @empty(request()->input('from'))
      <div class="row">
        <div class="col-md-12">
          <h3 class="mb-1">CDNs</h3>
        </div>
        @foreach ($moduleConfig['branches'] ?? [] as $branch)
          @if (($branch['hidden'] ?? false) == false)
            <div class="col-md-3 col-sm-6 col-12">
              <a href="?from={{ $branch['slug'] }}" class="info-box">
                <span class="info-box-icon bg-info">
                  <img src="{{ $branch['ico'] }}" alt="">
                </span>

                <div class="info-box-content">
                  <span class="info-box-text">{{ $branch['name'] }}</span>
                </div>
                <!-- /.info-box-content -->
              </a>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          @endif
        @endforeach
        <div class="col-md-12">
          <h3 class="mb-1">Modules</h3>
        </div>
        @foreach ($modules ?? [] as $module)
          <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-header">{{ $module['name'] }}</div>
              <svg class="bd-placeholder-img card-img-bottom" width="100%" height="120"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#6c757d"></rect>
                {{-- <text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text> --}}
              </svg>
            </div>
          </div>
          <!-- /.col -->
        @endforeach
        <div class="col-md-12">
          <h3 class="mb-1">Themes</h3>
        </div>
        @foreach ($themes ?? [] as $theme)
          <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-header">{{ $theme['name'] }}</div>
              <svg class="bd-placeholder-img card-img-bottom" width="100%" height="120"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#6c757d"></rect>
                {{-- <text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text> --}}
              </svg>
            </div>
          </div>
          <!-- /.col -->
        @endforeach
        <div class="col-md-12">
          <h3 class="mb-1">Examples</h3>
        </div>
        @foreach ($examples ?? [] as $example)
          <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-header">{{ $example['name'] }}</div>
              <svg class="bd-placeholder-img card-img-bottom" width="100%" height="120"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#6c757d"></rect>
                {{-- <text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text> --}}
              </svg>
            </div>
          </div>
          <!-- /.col -->
        @endforeach
      </div>
    @else
      {{-- @include('market::admin.' . request()->input('from')) --}}
      @isset($projects)
        <div class="row">
          @isset($branch['form'])
            <div class="col-md-12">
              <form action="">
                @foreach (request()->except('search') as $key => $value)
                  <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Search" name="search"
                    value="{{ request()->input('search') }}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          @endisset
          @foreach ($projects ?? [] as $project)
            <div class="col-md-3 col-sm-6 col-12">
              <a href="?from={{ request()->input('from') }}&name={{ $project['name'] }}" class="info-box">
                <div class="info-box-content">
                  <span class="info-box-text">{{ $project['name'] }}</span>
                </div>
                <!-- /.info-box-content -->
              </a>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          @endforeach
        </div>
      @else
        @isset($versions)
          <div class="row mb-2">
            <div class="col-md-12">
              <div class="jumbotron mb-2">
                <h1 class="display-4">{{ $versions['name'] ?? '' }}</h1>
                <hr class="my-4">
                <p>{{ $versions['description'] ?? '' }}</p>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <form method="post">
                @csrf
                @foreach (request()->except(['search', '_token']) as $key => $value)
                  <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="input-group">
                  <select class="form-control" name="version">
                    @php
                      if (!empty($versions['versions']) && !is_array($versions['versions'])) {
                          $versions['versions'] = (array) $versions['versions'];
                      }
                    @endphp
                    @foreach ($versions['versions'] ?? [] as $version)
                      <option value="{{ $version }}" @if (request()->input('version') == $version) selected @endif>
                        {{ $version }}
                      </option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          @if (request()->method() == 'POST')
            <div class="row mb-2">
              @php
                $version = request()->input('version');
                $version_url =
                    'https://registry.npmjs.org/' .
                    $versions['name'] .
                    '/-/' .
                    $versions['name'] .
                    '-' .
                    $version .
                    '.tgz';
              @endphp
              <x-market::admin.install-card :props="array_merge($versions, [
                  'version' => $version,
                  'version_url' => $version_url,
                  'type' => '',
              ])"></x-market::admin.install-card>
            </div>
          @endif
        @endisset
        @isset($project_installed)
          <div class="row row-cols-4">
            @foreach ($project_installed['versions'] ?? [] as $version => $version_files)
              @php
                $version_url =
                    'https://registry.npmjs.org/' .
                    $project_installed['name'] .
                    '/-/' .
                    $project_installed['name'] .
                    '-' .
                    $version .
                    '.tgz';
              @endphp
              <x-market::admin.install-card :props="array_merge($project_installed, [
                  'versions' => [$version],
                  'version_url' => $version_url,
                  'installed' => isset($project_installed['versions'][$version]),
              ])"></x-market::admin.install-card>
            @endforeach
          </div>
        @endisset
        @endisset @endempty
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @push('scripts')
      <script>
        const progress = document.getElementById('install-progress');

        function appendProgressInfo(message, type, replace = false) {
          if (replace) progress.removeChild(progress.children[progress.children.length - 1]);
          const p = document.createElement('p');
          p.innerHTML = message.trim();
          if (type) p.className = 'text-' + type;
          progress.appendChild(p);
        }

        function updateProgress(percent) {
          document.getElementsByClassName("progress-bar")[0].style.width = percent + "%";
          // document.getElementsByClassName("progress-bar")[0].innerHTML = "%u%% Complete";
        }
      </script>

      @php
        function appendProgressInfo($message, $type = 'light', $replace = false)
        {
            //   sleep(rand(1, 2));
            $suffixMessage = '';
            $prefixMessage = '';
            switch ($type) {
                case 'light':
                    $prefixMessage = '<i class="spinner-grow spinner-grow-sm"></i>';
                    $suffixMessage = '    <i class="fa fa-ellipsis"></i>';
                    break;
                case 'success':
                    $prefixMessage = '<i class="fa fa-check"></i>';
                    break;
                case 'danger':
                    $prefixMessage = '<i class="fa fa-xmark"></i>';
                    break;
                default:
                    break;
            }
            echo '<script>
              appendProgressInfo(\''.addslashes(trim($prefixMessage.$message.$suffixMessage)).
                  '\', \''.$type.
                  '\', '.$replace.
                  ');
            </script>';
            echo ob_get_clean();
            flush();
        }
        function updateProgress($percent)
        {
            $script = '<script>
              updateProgress("%u")
            </script>';
            echo sprintf($script, $percent);
            echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
            flush(); //刷新缓冲区的内容，输出
        }
        //   if ($ftp_connect_error_message === true && $db_connect_error_message === true) {

        //       $localFile;
        //       // 检测本地应用包
        //       foreach ($package['urls'] as $url) {
        //           $file = $software->name . '-' . $package['version'] . '.zip';
        //           if (file_exists(__DIR__ . '/../../../scripts/' . $software->name . '/' . $file)) {
        //               $localFile = $file;
        //               break;
        //           }
        //       }
        //       if (!empty($localFile)) {
        //           appendProgressInfo('<i class="fa fa-check"></i>检测到本地应用包.' . $localFile, 'success');
        //       } else {
        //           //   appendProgressInfo('<i class="spinner-grow spinner-grow-sm"></i>未检测到本地应用包');
        //           appendProgressInfo('未检测到本地应用包');
        //       }
        //       // 未检测到本地应用包，下载远程应用包
        //       if (empty($localFile)) {
        //           $remoteFile;
        //           foreach ($package['urls'] as $index => $url) {
        //               var_dump(pathinfo($url));
        //               $file = $software->name . '-' . $package['version'] . '.zip';
        //               appendProgressInfo('<i class="spinner-grow spinner-grow-sm"></i>连接远程应用包(' . ($index + 1) . '/' . sizeof($package['urls']) . ')');
        //               $fp_input;
        //               try {
        //                   $fp_input = fopen($url, 'r');
        //                   appendProgressInfo('<i class="fa fa-check"></i>连接远程应用包(' . ($index + 1) . '/' . sizeof($package['urls']) . ')', 'success', true);
        //                   file_put_contents(__DIR__ . '/../../../scripts/' . $software->name . '/' . $file, $fp_input);
        //                   $localFile = $file;
        //                   break;
        //               } catch (Exception $e) {
        //                   appendProgressInfo($e->getMessage(), 'danger');
        //               }
        //           }
        //       }
        //       if (!file_exists(__DIR__ . '/../../../scripts/' . $software->name . '/' . pathinfo($localFile)['filename'])) {
        //           try {
        //               appendProgressInfo('<i class="spinner-grow spinner-grow-sm"></i>解压缩应用包');
        //               var_dump(__DIR__ . '/../../../scripts/' . $software->name . '/' . $localFile);
        //               var_dump(pathinfo($localFile));
        //               $zip = app('zip')::open(__DIR__ . '/../../../scripts/' . $software->name . '/' . $localFile);
        //               $zip->extract(__DIR__ . '/../../../scripts/' . $software->name . '/' . pathinfo($localFile)['filename'], true);
        //               appendProgressInfo('<i class="fa fa-check"></i>应用包解压完成');
        //           } catch (Exception $e) {
        //               appendProgressInfo('<i class="fa fa-close"></i>' . $e->getMessage(), 'danger');
        //           }
        //       } else {
        //           appendProgressInfo('<i class="fa fa-check"></i>检测到本地存在已解压应用包目录.', 'success');
        //       }
        //       try {
        //           appendProgressInfo('<i class="spinner-grow spinner-grow-sm"></i>上传至 FTP');
        //           //   var_dump($controller);
        //           $controller->ftp->putAll(__DIR__ . '/../../../scripts/' . $software->name . '/' . pathinfo($localFile)['filename'], $request->ftp_dir_path);
        //           appendProgressInfo('<i class="fa fa-check"></i>上传至 FTP', 'success', true);
        //           updateProgress(50);
        //       } catch (Exception $e) {
        //           appendProgressInfo('<i class="fa fa-close"></i>' . $e->getMessage(), 'danger');
        //       }

        //       //   var_dump($request->all());
        //       //   var_dump($package);
        //       //   appendProgressInfo('未检测到本地应用包，连接远程应用包.<i class="spinner-grow spinner-grow-sm"></i>');
        //   }
        //   ob_end_flush();
      @endphp
      {{-- $script = '<script>
    appendProgressInfo("%u%", "%u%", );
  </script>'; --}}
      {{-- for ($i = 0; $i < 101; $i++) {
          sleep(rand(1, 2));
          $_script = '<script>
            document.getElementsByClassName("progress-bar")[0].style.width = "%u%%";
            document.getElementsByClassName("progress-bar")[0].innerHTML = "%u%% Complete";
          </script>';
          echo sprintf($_script, $i, $i);
          echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
          flush(); //刷新缓冲区的内容，输出
      } --}}
    @endpush
