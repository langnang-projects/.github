@extends('home.index')

@section('content')
  <div class="mt-8 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 ml:-1 mr:-1">
    @foreach (Module::all() ?? [] as $moduleName => $module)
      @if (Module::isEnabled($moduleName))
        <a class="m-1 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg"
          href="/{{ Config::get(strtolower($moduleName) . '.prefix') ?? strtolower($moduleName) }}">
          <div class="p-4 px-6">
            <div class="flex items-center">
            @empty(Config::get(strtolower($moduleName) . '.ico'))
              <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 1024 1024" class="w-8 h-8 text-gray-500 d-none">
                <path
                  d="M871.9 259.8L552 75.9c-24-16-56-16-80 0L152.1 259.8c-24 16-40 40-40 68v367.9c0 28 16 56 40 68L472 947.6c24 16 56 16 80 0l319.9-183.9c24-16 40-40 40-68V327.8c0-28-16-56-40-68z m-1.1 418c0 25.1-14.4 46.7-35.9 61L547.8 904c-21.5 14.4-50.3 14.4-71.8 0L188.8 738.9c-21.5-10.8-35.9-35.9-35.9-61V347.6c0-25.1 14.4-46.7 35.9-61L476 121.4c21.5-14.4 50.3-14.4 71.8 0L835 286.5c21.5 10.8 35.9 35.9 35.9 61v330.3z"
                  p-id="4277"></path>
                <path
                  d="M793.6 345.8c-5.8-10.1-18.6-13.5-28.5-7.5L512.2 489.6l-257.6-150c-10.2-5.9-23.3-2.6-29.2 7.5-6 10.1-2.6 23 7.6 29l260.2 151.6-2.4 288.1c-0.1 11 8.8 20.1 19.8 20.2 11 0.1 20.1-8.8 20.2-19.8l2.4-289.7L786.3 375c9.9-6.1 13.2-19.1 7.3-29.2z"
                  p-id="4278"></path>
              </svg>
            @endempty
            <div class="ml-4 text-lg leading-7 font-semibold">
              <span class="underline text-gray-900 dark:text-white">{{ $moduleName }}</span>
            </div>
          </div>
        </div>
      </a>
    @endif
  @endforeach
</div>
@endsection
