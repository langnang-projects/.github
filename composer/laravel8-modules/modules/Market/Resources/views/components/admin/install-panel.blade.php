@props([
    'props' => [],
])

@once
  @push('styles')
    <style>
      #install-progress p {
        margin-bottom: 0;
        padding-left: 20px;
      }

      #install-progress p>i {
        width: 14px;
        height: 14px;
        margin-right: 6px;
        text-align: center;
        vertical-align: middle;
      }

      #install-progress p>i:first-child {
        margin-left: -20px;

      }

      @keyframes ellipsis {

        /*动态改变显示宽度, 但始终让总占据空间不变, 避免抖动*/
        0% {
          width: 0;
          margin-right: 12px;
        }

        33% {
          width: 4px;
          margin-right: 8px;
        }

        66% {
          width: 8px;
          margin-right: 4px;
        }

        100% {
          width: 12px;
          margin-right: 0;
        }
      }

      #install-progress p>i.fa-ellipsis {
        animation: ellipsis 3s infinite step-start;
        overflow: hidden;
      }

      #install-progress p .spinner-grow-sm {
        vertical-align: middle;
      }
    </style>
  @endpush
@endonce

<div class="section install-progress">

  <div class="progress" style="height: 30px;border-radius: 10px;">
    <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" aria-valuenow="75"
      aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
  </div>
  <div class="card" style="margin-top: 10px;">
    <div class="card-body text-light" id="install-progress" style="background: #302C42;">
      {{-- <p>FTP 连接成功.</p> --}}
      {{-- <p>MySQL 连接成功.</p> --}}
      {{-- <p>未检测到本地应用包，连接远程应用包</p> --}}
      {{-- <p>远程应用包连接成功，启动下载应用包.(0/2000)</p> --}}
      {{-- <p>应用包下载完成，启动解压缩.</p> --}}
      {{-- <p>解压缩完成，FTP 上传.</p> --}}
    </div>
  </div>
</div>
