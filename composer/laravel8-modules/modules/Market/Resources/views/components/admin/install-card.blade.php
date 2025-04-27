@props([
    'props' => [],
])

<div class="col mb-2" data-id="module-" data-name="{{ $props['name'] ?? '' }}" data-slug="{{ $props['slug'] ?? '' }}"
  data-version="{{ $props['version'] ?? '' }}" data-version-url="{{ $props['version_url'] ?? '' }}">
  @isset($props['type'])
    <div class="progress" role="install-progress" style="height: 30px;border-radius: 10px;">
      <div class="progress-bar text-left bg-primary" role="progressbar" style="width: 0%"></div>
    </div>
    <div class="card mt-2">
      <div class="card-body text-light" role="install-message" style="background: #302C42;">
        <button class="btn btn-sm btn-primary" type="submit" style="padding: .03rem .5rem;">Submit</button>
        {{-- <p>FTP 连接成功.</p> --}}
        {{-- <p>MySQL 连接成功.</p> --}}
        {{-- <p>未检测到本地应用包，连接远程应用包</p> --}}
        {{-- <p>远程应用包连接成功，启动下载应用包.(0/2000)</p> --}}
        {{-- <p>应用包下载完成，启动解压缩.</p> --}}
        {{-- <p>解压缩完成，FTP 上传.</p> --}}
      </div>
    </div>
    <div class="card mt-2 d-none">
      <a href="#" class="card-header py-2 pl-2 text-decoration-none">
        <i class="fa-solid fa-folder"></i>
        <span>{{ $props['name'] }}-{{ $props['version'] }}/</span>
      </a>
      <ul class="list-group list-group-flush" role="install-path">
      </ul>
    </div>
  @else
    <div class="card">
      @isset($props['name'])
        <div class="card-header p-2 text-decoration-none text-reset" href="/admin/market/{{ $props['slug'] ?? '' }}"
          title="{{ $props['name'] ?? ($props['slug'] ?? '') }}">
          <div class="media">
            @if (empty($props['ico']) || !is_url($props['ico']))
              <i class="{{ $props['ico'] ?? 'bi bi-box-fill' }} align-self-center mr-2"></i>
            @else
              <img src="{{ $props['ico'] ?? '' }}" class="align-self-center mr-2" height="24" alt="...">
            @endif
            <div class="media-body text-truncate">
              <p class="mb-0"> {{ $props['name'] ?? ($props['slug'] ?? '') }} </p>
            </div>
          </div>
        </div>
      @endisset

      @isset($props['description'])
        <div class="card-body text-wrap text-truncate p-2 pb-1 small"
          style="padding-bottom: 0.25rem!important;height: 54px;" data-toggle="tooltip" data-placement="top"
          title="{{ $props['description'] ?? '' }}">
          {{ $props['description'] ?? '' }}
        </div>
      @endisset

      <div class="progress" style="height: 0.5rem;border-radius: 99rem;background-color: transparent;"
        role="install-progress">
        <div class="progress-bar text-left bg-primary" role="progressbar" style="width: 0%;"></div>
      </div>

      <div class="card-footer text-right pt-1 pr-2 pb-1 pl-2 @isset($props['hidden_footer']) d-none @endisset">
        @if (!empty($props['versions']) && sizeof($props['versions']) > 0)
          <div class="btn-group btn-group-xs float-left">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
              aria-expanded="false">
              <span>{{ $props['versions'][0] }}</span>
            </button>
            <div class="dropdown-menu">
              @foreach ($props['versions'] ?? [] as $pkg)
                <span class="dropdown-item" style="cursor: pointer;">{{ $pkg }}</span>
              @endforeach
            </div>
          </div>
        @endif
        @empty($props['installed'])
          <button type="button" class="btn btn-xs btn-outline-primary" role="install-btn">
            <i class="bi bi-download"></i> 安装
          </button>
        @else
          <button type="button" class="btn btn-xs btn-warning" role="install-btn">
            <i class="bi bi-download"></i> 重装
          </button>
        @endempty
        <button type="button" class="btn btn-xs sr-only btn-outline-dark" role="install-progress-btn">
          <div class="progress"
            style="margin: 0 -0.25rem;height: 1rem;border-radius: 0rem;background-color: transparent;">
            <div class="progress-bar bg-dark" role="progressbar" style="width: 0%;"></div>
          </div>
          <div class="sr-only" style="margin-top: -1rem;" role="install-start-text">
            <i class="bi bi-play-circle"></i> 继续
          </div>
          <div class="sr-only" style="margin-top: -1rem;" role="install-pause-text">
            <i class="bi bi-pause-circle"></i> 暂停
          </div>
        </button>
        <button type="button" class="btn btn-xs sr-only btn-outline-success" role="install-success-btn">
          <i class="bi bi-check-lg"></i> 成功
        </button>
        @empty($props['installed'])
        @else
          <button type="button" class="btn btn-xs btn-outline-secondary">
            <i class="bi bi-gear"></i> 配置
          </button>

          {{-- <button type="button" class="btn btn-xs sr-only btn-outline-danger" role="uninstall-btn">
          <i class="bi bi-trash"></i> 卸载
        </button> --}}
        @endempty
      </div>

    </div>
  @endisset
</div>

@once
  @push('scripts')
    <script>
      const operatePackage = (data, callback) => axios({
        url: "/api/market/operate",
        method: "POST",
        data,
      }).then(res => {
        const {
          next
        } = res
        console.log(`operatePackage ~ then`, res)
        callback(res);
        if (next && next.operate) {
          operatePackage(next, callback);
        }
      }).catch(err => {
        console.log(`operatePackage ~ catch`, err)
      });
      const getPackageInfo = (data) => axios({
        url: "/api/market/jsdeliver",
        method: "POST",
        data: {
          ...data,
          operate: 'start',
        },
      });
      const getPackageProgress = (data) => axios({
        url: "/api/market/jsdeliver",
        method: "POST",
        data: {
          ...data,
          operate: 'progress',
        },
      }).then(res => {
        console.log(res.data);
        if (res.data.byetRange[1] < res.data.size) {
          getPackageProgress({
            url: res.data.url,
            byetRange: [res.data.byetRange[1] + 1, res.data.byetRange[1] + res.data.streamInterval]
          })
        } else {

        }
      });
      $(document).on('click', '[role="install-btn"]', function() {
        console.log(this);
        console.log($(this));
        console.log($(this).parents('[data-id]'));
        const element = $(this).parents('[data-id]')
        handleInstallStart(element);
      })

      $(document).on('click', '.dropdown-item', function() {
        $(this).parent().prev().find('span').text($(this).text());
      })

      function appendProgressMessage(element, message, type, replace = false) {
        let $suffixMessage = '';
        let $prefixMessage = '';
        switch (type) {
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
        message = $suffixMessage + message + $prefixMessage;
        // if (replace) element.removeChild(element.children[element.children.length - 1]);
        const p = document.createElement('p');
        p.innerHTML = message.trim();
        if (type) p.className = 'text-' + type;
        console.log(element, message, type);
        element.append(`<p class="mb-0 text-${type}">${message.trim()}</p>`);
      }

      function handleInstallStart(element) {
        $(element).find('[role="install-btn"]').addClass('sr-only');
        $(element).find('[role="install-progress-btn"]').removeClass('sr-only');
        $(element).find('[role="install-pause-text"]').removeClass('sr-only');
        const slug = $(element).attr('data-slug');
        const name = $(element).attr('data-name') || $(element).find('.card-header .media-body p').text().trim();
        const version = $(element).find('.dropdown-toggle span').text().trim() || $(element).attr('data-version');
        const progressMessage = $(element).find('[role="install-message"]')
        const version_url = $(element).attr('data-version-url');
        let size = 0;
        let url = version_url || `{{ $module['version_url'] ?? '' }}`
        // let url = 'http://dl.font.im/Roboto.zip';
        url = url.replace(/\{\{slug\}\}/g, slug);
        url = url.replace(/\{\{name\}\}/g, name);
        url = url.replace(/\{\{version\}\}/g, version);
        operatePackage({
          name,
          slug,
          version,
          url,
          operate: 'start',
        }, function(res) {
          console.log(`operatePackage ~ callback`, res);
          const {
            operate
          } = res.next;
          const prevOperate = res.operate;
          if (operate == 'download') {
            const {
              file_progress
            } = res;
            console.log(`download`, {
              file_progress
            });
            $(element).find('[role="install-progress"] .progress-bar').css('width', file_progress * 100 + '%');
            // $toast.info(`${operate} ${name}`);
            appendProgressMessage($(element).find('[role="install-message"]'), '远程应用包连接成功，启动下载应用包', 'lignt',
              true);
          }

          if (prevOperate == 'path') {
            window.$app.files = res.files;
            console.log(res);
            $(element).find('[role="install-path"]').parent().removeClass('d-none');
            handleUpdatePath();
          }

          if (operate == 'unzip') {
            // progress-bar-striped
            $(element).find('[role="install-progress"] .progress-bar')
              .css('width', '100%')
              .addClass('progress-bar-striped');
            // $toast.info(`${operate} ${name}`);
          }
          if (operate == 'install') {
            // progress-bar-striped
            $(element).find('[role="install-progress"] .progress-bar')
              .addClass('progress-bar-animated');
            // $toast.info(`${operate} ${name}`);
          }
          if (operate == 'finish') {
            // progress-bar-striped
            $(element).find('[role="install-progress"] .progress-bar')
              .removeClass('progress-bar-striped')
              .removeClass('progress-bar-animated')
              .addClass('bg-success');

            $(element).find('[role="install-progress-btn"]').addClass('sr-only');
            $(element).find('[role="install-success-btn"]').removeClass('sr-only');
            setTimeout(function() {
              $(element).find('[role="install-success-btn"]').addClass('sr-only');
              $(element).find('[role="uninstall-btn"]').removeClass('sr-only');
              window.location.href = window.location.origin + window.location.pathname + '/' + version;
            }, 5000)
            // $toast.info(`${operate} ${name}`);
          }
        });
        // // const url = 'https://npmmirror.com/mirrors/node/v18.18.0/node-v18.18.0-x64.msi';
        // getPackageInfo({
        //   url,
        // }).then((res) => {
        //   getPackageProgress({
        //     url,
        //     byetRange: [0, res.data.streamInterval - 1],
        //   });
        // }).then(res => {
        //   console.log(res);
        // }).catch((err) => {

        // });
        // let progress = 0;
        // const timeouter = function() {
        //   setTimeout(() => {
        //     progress += 10
        //     $(element).find('[role="install-progress"] .progress-bar').css('width', progress + '%');
        //     if (progress <= 100) {
        //       timeouter()
        //     } else {
        //       $(element).find('[role="install-progress-btn"]').addClass('sr-only');
        //       $(element).find('[role="install-success-btn"]').removeClass('sr-only');

        //       setTimeout(function() {
        //         $(element).find('[role="install-success-btn"]').addClass('sr-only');
        //         $(element).find('[role="uninstall-btn"]').removeClass('sr-only');
        //       }, 5000)
        //     }
        //   }, 500);
        // }

        // timeouter();

      }

      $(document).on('click', '[data-path]', function(event) {
        console.log(`$([data-path])`, {
          ...arguments
        });
        handleUpdatePath($(this).attr('data-path'))
      })

      function handleUpdatePath($index = null) {
        console.log(`handleUpdatePath ~ arguments`, {
          $index,
          files: window.$app.files,
          element: $('[role="install-path"]')
        })
        let html = '';
        let header = `${$app.project.name}-${$app.project.version}/`;
        let files = [...$app.files];

        console.log(`handleUpdatePath ~ html`, html);
        if (!$index) {
          html = files.reduce((total, current, index, array) => {
            console.log(`handleUpdatePath ~ files.reduce ~ ${index} ~ before`, total);
            // total += `<li class="list-group-item py-2" data-path="${index}">`;
            if (current.type == 'dir') {
              total += `<a href="#" class="list-group-item py-2 text-decoration-none" data-path="${index}">`;
              total += `<i class="fa-solid fa-folder"></i>`
              total += ` ${current.basename}`
              total += `</a>`
            } else {
              total += `<li class="list-group-item py-2">`;
              total += `<i class="fa-solid fa-file"></i>`
              total += ` ${current.basename}`
              total += `</li>`
            }
            // total += ` ${current.basename}`
            // total += `</li>`
            console.log(`handleUpdatePath ~ files.reduce ~ ${index} ~ after`, total);
            return total;
          }, '')
          $('[role="install-path"]').prev().attr('data-path', null);
        } else {
          files = $index.split('').reduce((total, current, index) => {
            // const header = $('[role="install-path"]').prev().find('span').text()
            // $('[role="install-path"]').prev().find('span').text(header + total[current].basename + '/')
            header += total[current].basename + '/';
            return total[current].children;
          }, files)
          html = files.reduce((total, current, index, array) => {
            // $('[role="install-path"]').prev().find('span').html();
            console.log(`handleUpdatePath ~ files.reduce ~ ${index} ~ before`, {
              total,
            });
            // total += `<li class="list-group-item py-2" data-path="${$index}${index}">`;
            if (current.type == 'dir') {
              total += `<a href="#" class="list-group-item py-2 text-decoration-none" data-path="${$index}${index}">`;
              total += `<i class="fa-solid fa-folder"></i>`
              total += ` ${current.basename}`
              total += `</a>`
            } else {
              total += `<li class="list-group-item py-2">`;
              total += `<i class="fa-solid fa-file"></i>`
              total += ` ${current.basename}`
              total += `</li>`
            }
            // total += ` ${current.basename}`
            // total += `</li>`
            console.log(`handleUpdatePath ~ files.reduce ~ ${index} ~ after`, total);
            return total;
          }, '')
          $('[role="install-path"]').prev().attr('data-path', $index.slice(0, -1));
        }
        console.log(`handleUpdatePath ~ html`, html);

        $('[role="install-path"]').prev().find('span').text(header)
        $('[role="install-path"]').html(html);
      }

      function handleInstallPause(element) {}
    </script>
  @endpush

@endonce
@once
  @push('scripts')
    @isset($props['type'])
      <script>
        console.log($('[data-id]').eq(0))
        handleInstallStart($('[data-id]').eq(0));
      </script>
    @endisset
  @endpush
@endonce
