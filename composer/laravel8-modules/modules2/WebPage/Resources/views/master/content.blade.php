<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Module WebPage</title>

  {{-- Laravel Mix - CSS File --}}
  {{-- <link rel="stylesheet" href="{{ mix('css/webpage.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('public/lib/normalize.css/8.0.1/normalize.css') }}">
  <style>
    {!! $content->style !!}
  </style>
</head>

<body>
  {!! $content->html !!}
  {{-- Laravel Mix - JS File --}}
  {{-- <script src="{{ mix('js/webpage.js') }}"></script> --}}
  <script>
    {!! $content->script !!}
  </script>
</body>

</html>
