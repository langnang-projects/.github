{{-- @props([]) --}}
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ env('APP_URL') . $admin['alias'] }}" class="brand-link text-center">
    @empty(Arr::get($admin, 'config.logo'))
    @else
      <img src="{{ Arr::get($admin, 'config.logo') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    @endempty
    <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-none">
      <div class="image">
        <img src="{{ asset('/modules/Admin/Public/master/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline d-none">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach (Arr::get($admin, 'categories', []) as $category)
          @if (sizeof($category['children']) > 0)
            <li class="nav-item @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category['slug']))) menu-is-opening menu-open @endif">
              <a href="{{ url(Str::replace(':', '/', $category['slug'])) }}" class="nav-link @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category['slug']))) active @endif">
                <i class="nav-icon @empty($category['ico'])  'fas fa-circle' @else {{ $category['ico'] }}  @endempty"></i>
                <p class="">
                  {{ $category['name'] }}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category['slug']))) style="display: block;" @endif>
                @foreach ($category['children'] ?? [] as $child_01)
                  <li class="nav-item">
                    <a href="{{ url(Str::replace(':', '/', $child_01['slug'])) }}" class="nav-link @if (Str::startsWith(request()->path(), Str::replace(':', '/', $child_01['slug']))) active @endif">
                      <i class="nav-icon @empty($child_01['ico']) far fa-circle @else {{ $child_01['ico'] }}  @endempty"></i>
                      <p class="">
                        {{ $child_01['name'] }}
                      </p>
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ url(Str::replace(':', '/', $category['slug'])) }}" class="nav-link">
                <i class="nav-icon @empty($category['ico'])  'fas fa-circle' @else {{ $category['ico'] }}  @endempty"></i>
                <p>
                  {{ $category['name'] }}
                </p>
              </a>
            </li>
          @endif
        @endforeach
        <li class="nav-item d-none">
          <a href="admin/helpers" class="nav-link ">
            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
            <p class="">
              Helpers
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="admin/helpers/about" class="nav-link ">
                <i class="nav-icon  far fa-circle "></i>
                <p class="">
                  About
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="admin/helpers/plugins" class="nav-link ">
                <i class="nav-icon  far fa-circle "></i>
                <p class="">
                  Plugins
                </p>
              </a>
            </li>

          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
