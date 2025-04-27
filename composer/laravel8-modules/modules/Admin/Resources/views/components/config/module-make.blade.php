@props([
    'props' => [],
])
@php
  $target = $props[0] ?? null;
  $makePrepend = $props[1] ?? null;
  $makeAppend = $props[2] ?? null;
  $title = $props[3] ?? null;
  $description = $props[4] ?? null;
  $files = $props[5] ?? [];
@endphp
<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">{{ $title ?? (isset($target) ? Str::of($target)->plural()->camel()->ucfirst() : 'title') }}
      <small>{{ $description ?? '' }}</small>
    </h3>
    @isset($target)
      <form method="POST" class="card-tools mb-0">
        @csrf
        <input type="hidden" name='_target' value="make-{{ $target }}">

        <div class="input-group input-group-sm" style="width: 280px;">
          @isset($makePrepend)
            <div class="input-group-prepend">
              <span class="input-group-text">{{ $makePrepend }}</span>
              <input type="hidden" name='make-prepend' value="{{ $makePrepend }}">
            </div>
          @endisset
          <input type="text" name="{{ $target }}" class="form-control float-right"
            placeholder="Make {{ Str::of($target)->camel()->ucfirst() }}">
          <div class="input-group-append">
            @isset($makeAppend)
              <input type="hidden" name='make-append' value="{{ $makeAppend }}">
              <span class="input-group-text">{{ $makeAppend }}</span>
            @endisset
            <button type="submit" class="btn btn-default">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
      </form>
    @endisset
  </div>
  <!-- /.card-header -->
  <div class="card-body @if ($slot->isEmpty()) d-none @endif">
    {{ $slot }}
  </div>


  <ul class="list-group list-group-flush">
    @foreach ($files as $file)
      <li class="list-group-item">
        <div class="form-group mb-0">
          <div class="icheck-primary d-inline">
            <input type="checkbox" disabled>
            <label>
              {{-- {{ $file }} --}}
              {{-- {{ Str::of($target)->plural() }} --}}
              {{-- {{ config('modules.config.files.' . Str::of($target)->plural()) }} --}}
              {{-- {{ Str::of($file)->after(config('modules.paths.generator.' . $target))->before('.blade') }} --}}
              {{-- {{ Str::of($file)->after(config('modules.paths.generator.' . $target)) }} --}}
              {{ Str::of($file)->after(config('modules.paths.generator.' . $target . '.path') . '\\')->before('.blade') }}
            </label>
          </div>
        </div>
      </li>
    @endforeach
  </ul>

  <div class="card-footer d-none">
    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
  </div>
</div>
