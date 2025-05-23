<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ env('APP_NAME', 'Lumen') }}</title>

  <!-- Fonts -->
  {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> --}}

  <!-- Styles -->
  <style>
    /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
    html {
      line-height: 1.15;
      -webkit-text-size-adjust: 100%
    }

    body {
      margin: 0
    }

    a {
      background-color: transparent
    }

    [hidden] {
      display: none
    }

    html {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
      line-height: 1.5
    }

    *,
    :after,
    :before {
      box-sizing: border-box;
      border: 0 solid #e2e8f0
    }

    a {
      color: inherit;
      text-decoration: inherit
    }

    svg,
    video {
      display: block;
      vertical-align: middle
    }

    video {
      max-width: 100%;
      height: auto
    }

    .bg-white {
      --bg-opacity: 1;
      background-color: #fff;
      background-color: rgba(255, 255, 255, var(--bg-opacity))
    }

    .bg-gray-100 {
      --bg-opacity: 1;
      background-color: #f7fafc;
      background-color: rgba(247, 250, 252, var(--bg-opacity))
    }

    .border-gray-200 {
      --border-opacity: 1;
      border-color: #edf2f7;
      border-color: rgba(237, 242, 247, var(--border-opacity))
    }

    .border-t {
      border-top-width: 1px
    }

    .flex {
      display: flex
    }

    .grid {
      display: grid
    }

    .hidden {
      display: none
    }

    .items-center {
      align-items: center
    }

    .justify-center {
      justify-content: center
    }

    .font-semibold {
      font-weight: 600
    }

    .h-5 {
      height: 1.25rem
    }

    .h-8 {
      height: 2rem
    }

    .h-16 {
      height: 4rem
    }

    .text-sm {
      font-size: .875rem
    }

    .text-lg {
      font-size: 1.125rem
    }

    .leading-7 {
      line-height: 1.75rem
    }

    .mx-auto {
      margin-left: auto;
      margin-right: auto
    }

    .ml-1 {
      margin-left: .25rem
    }

    .mt-2 {
      margin-top: .5rem
    }

    .mr-2 {
      margin-right: .5rem
    }

    .ml-2 {
      margin-left: .5rem
    }

    .mt-4 {
      margin-top: 1rem
    }

    .ml-4 {
      margin-left: 1rem
    }

    .mt-8 {
      margin-top: 2rem
    }

    .ml-12 {
      margin-left: 3rem
    }

    .-mt-px {
      margin-top: -1px
    }

    .max-w-6xl {
      max-width: 72rem
    }

    .min-h-screen {
      min-height: 100vh
    }

    .overflow-hidden {
      overflow: hidden
    }

    .p-6 {
      padding: 1.5rem
    }

    .py-4 {
      padding-top: 1rem;
      padding-bottom: 1rem
    }

    .px-6 {
      padding-left: 1.5rem;
      padding-right: 1.5rem
    }

    .pt-8 {
      padding-top: 2rem
    }

    .fixed {
      position: fixed
    }

    .relative {
      position: relative
    }

    .top-0 {
      top: 0
    }

    .right-0 {
      right: 0
    }

    .shadow {
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
    }

    .text-center {
      text-align: center
    }

    .text-gray-200 {
      --text-opacity: 1;
      color: #edf2f7;
      color: rgba(237, 242, 247, var(--text-opacity))
    }

    .text-gray-300 {
      --text-opacity: 1;
      color: #e2e8f0;
      color: rgba(226, 232, 240, var(--text-opacity))
    }

    .text-gray-400 {
      --text-opacity: 1;
      color: #cbd5e0;
      color: rgba(203, 213, 224, var(--text-opacity))
    }

    .text-gray-500 {
      --text-opacity: 1;
      color: #a0aec0;
      color: rgba(160, 174, 192, var(--text-opacity))
    }

    .text-gray-600 {
      --text-opacity: 1;
      color: #718096;
      color: rgba(113, 128, 150, var(--text-opacity))
    }

    .text-gray-700 {
      --text-opacity: 1;
      color: #4a5568;
      color: rgba(74, 85, 104, var(--text-opacity))
    }

    .text-gray-900 {
      --text-opacity: 1;
      color: #1a202c;
      color: rgba(26, 32, 44, var(--text-opacity))
    }

    .underline {
      text-decoration: underline
    }

    .antialiased {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale
    }

    .w-5 {
      width: 1.25rem
    }

    .w-8 {
      width: 2rem
    }

    .w-auto {
      width: auto
    }

    .grid-cols-1 {
      grid-template-columns: repeat(1, minmax(0, 1fr))
    }

    @media (min-width:640px) {
      .sm\:rounded-lg {
        border-radius: .5rem
      }

      .sm\:block {
        display: block
      }

      .sm\:items-center {
        align-items: center
      }

      .sm\:justify-start {
        justify-content: flex-start
      }

      .sm\:justify-between {
        justify-content: space-between
      }

      .sm\:h-20 {
        height: 5rem
      }

      .sm\:ml-0 {
        margin-left: 0
      }

      .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem
      }

      .sm\:pt-0 {
        padding-top: 0
      }

      .sm\:text-left {
        text-align: left
      }

      .sm\:text-right {
        text-align: right
      }
    }

    @media (min-width:768px) {
      .md\:border-t-0 {
        border-top-width: 0
      }

      .md\:border-l {
        border-left-width: 1px
      }

      .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }
    }

    @media (min-width:1024px) {
      .lg\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem
      }
    }

    @media (prefers-color-scheme:dark) {
      .dark\:bg-gray-800 {
        --bg-opacity: 1;
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--bg-opacity))
      }

      .dark\:bg-gray-900 {
        --bg-opacity: 1;
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--bg-opacity))
      }

      .dark\:border-gray-700 {
        --border-opacity: 1;
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--border-opacity))
      }

      .dark\:text-white {
        --text-opacity: 1;
        color: #fff;
        color: rgba(255, 255, 255, var(--text-opacity))
      }

      .dark\:text-gray-400 {
        --text-opacity: 1;
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--text-opacity))
      }

      .dark\:text-gray-500 {
        --tw-text-opacity: 1;
        color: #6b7280;
        color: rgba(107, 114, 128, var(--tw-text-opacity))
      }
    }
  </style>

  <style>
    body {
      font-family: 'Nunito', sans-serif;
    }

    .iconic .iconic-lightbulb-base,
    .iconic .iconic-lightbulb-screw {
      fill: #fcd8d6;
      stroke: #fcd8d6;
    }

    .iconic .iconic-lightbulb-coil {
      fill: #f7928f;
      stroke: #f7928f;
    }

    .iconic-property-stroke {
      fill: none !important;
    }
  </style>
</head>

<body class="antialiased">
  <div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center pt-8 sm:justify-start sm:pt-0" style="color:#EF3B2D;">
        <svg xmlns="http://www.w3.org/2000/svg" class="iconic iconic-lightbulb" width="80" height="80"
          viewBox="0 0 128 128">
          <g class="iconic-metadata">
            <title>Lightbulb</title>
          </g>
          <defs>
            <clipPath id="iconic-size-lg-lightbulb-clip-0">
              <path d="M16.583 94h33.417v2.667l-39.083 6.375-.333-6.417z"></path>
            </clipPath>
            <clipPath id="iconic-size-lg-lightbulb-clip-1">
              <path d="M64 57l-14.5 8.25v16.75h-34.25l-1.5-16 50.25-23z"></path>
            </clipPath>
          </defs>
          <g data-width="64" data-height="128" class="iconic-lightbulb-lg iconic-container iconic-lg" display="inline"
            transform="translate(32)">
            <path stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-4 iconic-property-accent iconic-property-stroke"
              d="M44 122l-23.834 4.001"></path>
            <path stroke="#000" stroke-width="4" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-3 iconic-property-accent iconic-property-stroke"
              d="M48 112l-32 6" fill="none"></path>
            <path stroke="#000" stroke-width="4" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-2 iconic-property-accent iconic-property-stroke"
              d="M48 102l-32 6" fill="none"></path>
            <path clip-path="url(#iconic-size-lg-lightbulb-clip-0)" stroke="#000" stroke-width="4"
              stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-1 iconic-property-accent iconic-property-stroke"
              d="M48 92.5l-32 6" fill="none"></path>
            <path clip-path="url(#iconic-size-lg-lightbulb-clip-1)" stroke="#000" stroke-width="8"
              stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-6 iconic-property-stroke" d="M60 54l-20 9v18.75"
              fill="none"></path>
            <path clip-path="url(#iconic-size-lg-lightbulb-clip-1)" stroke="#000" stroke-width="8"
              stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-5 iconic-property-stroke" d="M24 68v13.75"
              fill="none"></path>
            <path
              d="M47 94h-30c-1.657 0-3.221-1.325-3.493-2.959l-1.014-6.082c-.272-1.634.85-2.959 2.507-2.959h34c1.657 0 2.779 1.325 2.507 2.959l-1.014 6.082c-.272 1.634-1.836 2.959-3.493 2.959z"
              class="iconic-lightbulb-base iconic-property-fill"></path>
            <path stroke="#000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-4 iconic-property-stroke" d="M60 38l-56 26"
              fill="none"></path>
            <path stroke="#000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-3 iconic-property-stroke" d="M60 22l-56 26"
              fill="none"></path>
            <path stroke="#000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-2 iconic-property-stroke" d="M60 6l-56 26"
              fill="none"></path>
            <path stroke="#000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-1 iconic-property-stroke" d="M30 4.114l-26 11.886"
              fill="none"></path>
          </g>
          <g data-width="16" data-height="32" class="iconic-lightbulb-md iconic-container iconic-md" display="none"
            transform="scale(4) translate(8)">
            <path stroke="#000" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-4 iconic-property-accent iconic-property-stroke"
              d="M5.5 31.5l5-1.429" fill="none"></path>
            <path stroke="#000" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-3 iconic-property-accent iconic-property-stroke"
              d="M4.5 29.5l7-2" fill="none"></path>
            <path stroke="#000" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-2 iconic-property-accent iconic-property-stroke"
              d="M4.5 27.5l7-2" fill="none"></path>
            <path stroke="#000" stroke-linecap="round"
              class="iconic-lightbulb-screw iconic-lightbulb-screw-1 iconic-property-accent iconic-property-stroke"
              d="M4.5 25.5l7-2" fill="none"></path>
            <path stroke="#000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-5 iconic-property-stroke" d="M12.5 18.5l-2 1v3.5"
              fill="none"></path>
            <path stroke="#000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-4 iconic-property-stroke" d="M5.5 23v-1.5"
              fill="none"></path>
            <path stroke="#000" stroke-width="3" stroke-linecap="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-3 iconic-property-stroke" d="M14.5 11.5l-13 6"
              fill="none"></path>
            <path stroke="#000" stroke-width="3" stroke-linecap="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-2 iconic-property-stroke" d="M14.5 5.5l-13 6"
              fill="none"></path>
            <path stroke="#000" stroke-width="3" stroke-linecap="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-1 iconic-property-stroke" d="M10.5 1.5l-9 4"
              fill="none"></path>
            <path
              d="M11 25h-6c-.552 0-1.142-.425-1.316-.949l-.367-1.103c-.175-.524.131-.949.684-.949h8c.552 0 .858.425.684.949l-.367 1.103c-.175.524-.764.949-1.316.949z"
              class="iconic-lightbulb-base iconic-property-fill"></path>
          </g>
          <g data-width="10" data-height="16" class="iconic-lightbulb-sm iconic-container iconic-sm" display="none"
            transform="scale(8) translate(3)">
            <path d="M7 14c0 1.105-.895 2-2 2s-2-.895-2-2"
              class="iconic-lightbulb-screw iconic-property-accent iconic-property-fill"></path>
            <path stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-4 iconic-property-stroke" d="M8 8l-2 1v2"
              fill="none"></path>
            <path stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-3 iconic-property-stroke" d="M4 10.5v.5"
              fill="none"></path>
            <path stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-2 iconic-property-stroke" d="M1 8l8-4"
              fill="none"></path>
            <path stroke="#000" stroke-width="2" stroke-linecap="round"
              class="iconic-lightbulb-coil iconic-lightbulb-coil-1 iconic-property-stroke" d="M7 1l-6 3"
              fill="none"></path>
            <path
              d="M1.776 12.553l-.553-1.106c-.123-.247 0-.447.276-.447h7c.276 0 .4.2.276.447l-.553 1.106c-.124.247-.448.447-.724.447h-5c-.276 0-.6-.2-.724-.447z"
              class="iconic-lightbulb-base iconic-property-fill"></path>
          </g>
        </svg>
        <h1 class="my-0" style="margin: 0;font-size: 4rem;line-height: 80px;">Lumen</h1>
      </div>

      <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-6">
            <div class="flex items-center">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                <path
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
              </svg>
              <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laravel.com/docs"
                  class="underline text-gray-900 dark:text-white">Documentation</a></div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are
                new to the framework or have previous experience with Laravel, we recommend reading all of the
                documentation from beginning to end.
              </div>
            </div>
          </div>

          <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <div class="flex items-center">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                <path
                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                </path>
                <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laracasts.com"
                  class="underline text-gray-900 dark:text-white">Laracasts</a></div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them
                out, see for yourself, and massively level up your development skills in the process.
              </div>
            </div>
          </div>

          <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                <path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                </path>
              </svg>
              <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laravel-news.com/"
                  class="underline text-gray-900 dark:text-white">Laravel News</a></div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                Laravel News is a community driven portal and newsletter aggregating all of the latest and most
                important news in the Laravel ecosystem, including new package releases and tutorials.
              </div>
            </div>
          </div>

          <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
            <div class="flex items-center">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                <path
                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
              </svg>
              <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                Laravel's robust library of first-party tools and libraries, such as <a
                  href="https://forge.laravel.com" class="underline">Forge</a>, <a href="https://vapor.laravel.com"
                  class="underline">Vapor</a>, <a href="https://nova.laravel.com" class="underline">Nova</a>, and <a
                  href="https://envoyer.io" class="underline">Envoyer</a> help you take your projects to the next
                level. Pair them with powerful
                open source libraries like <a href="https://laravel.com/docs/billing" class="underline">Cashier</a>,
                <a href="https://laravel.com/docs/dusk" class="underline">Dusk</a>, <a
                  href="https://laravel.com/docs/broadcasting" class="underline">Echo</a>, <a
                  href="https://laravel.com/docs/horizon" class="underline">Horizon</a>, <a
                  href="https://laravel.com/docs/sanctum" class="underline">Sanctum</a>, <a
                  href="https://laravel.com/docs/telescope" class="underline">Telescope</a>, and more.
              </div>
            </div>
          </div>
        </div>
      </div>

      @section('content')

      @show

      <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 sm:text-left">
          <div class="flex items-center">
            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
              stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
              <path
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
              </path>
            </svg>

            <a href="https://laravel.bigcartel.com" class="ml-1 underline">
              Shop
            </a>

            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
              <path
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
              </path>
            </svg>

            <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
              Sponsor
            </a>

            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" viewBox="0 0 1024 1024" class="ml-4 -mt-px w-5 h-5 text-gray-400">
              <path
                d="M519.68 1016.32a26.88 26.88 0 0 1-15.36-4.48l-407.68-235.52a30.08 30.08 0 0 1-16-26.88V278.4a30.08 30.08 0 0 1 16-26.88L504.32 16a30.72 30.72 0 0 1 31.36 0l407.68 235.52a30.72 30.72 0 0 1 15.36 26.88v471.04a30.72 30.72 0 0 1-15.36 26.88l-407.68 235.52a28.8 28.8 0 0 1-16 4.48z m-375.68-285.44l375.68 217.6 376.32-217.6V296.96L519.68 80 144 296.96z"
                fill="#a0aec0"></path>
              <path
                d="M519.68 540.8a28.16 28.16 0 0 1-15.36-4.48l-407.68-230.4a31.36 31.36 0 0 1-12.16-42.88 32.64 32.64 0 0 1 43.52-12.16l407.04 231.04a31.36 31.36 0 0 1-15.36 58.88z"
                fill="#a0aec0"></path>
              <path
                d="M512 545.28a31.36 31.36 0 0 1-15.36-58.88L901.12 256a31.36 31.36 0 0 1 42.88 12.16 32 32 0 0 1-12.16 42.88l-407.68 230.4a32 32 0 0 1-12.16 3.84z"
                fill="#a0aec0"></path>
              <path
                d="M519.68 1000.96a31.36 31.36 0 0 1-31.36-31.36V501.12a31.36 31.36 0 1 1 64 0v468.48a31.36 31.36 0 0 1-32.64 31.36z"
                fill="#a0aec0"></path>
            </svg>

            <a href="./module" class="ml-1 underline">
              Module
            </a>
          </div>
        </div>

        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
          {{ app()->version() }} (PHP v{{ PHP_VERSION }})
        </div>
      </div>
    </div>
  </div>
</body>

</html>
