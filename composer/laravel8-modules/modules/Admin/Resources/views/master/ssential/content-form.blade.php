@extends('admin::layouts.master')

@push('styles')
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/dropzone/min/dropzone.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/codemirror/codemirror.css') }}">
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master/plugins/codemirror/theme/monokai.css') }}">
  <style>
    .note-editor.card {
      margin-bottom: 0;
    }

    .codeMirror {
      height: auto !important;
      width: 100%;
      font-size: .875rem;
      font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, monospace;
    }

    .codeMirror-scroll {
      height: auto !important;
      min-height: 100px;
    }
  </style>
@endpush


@section('content')
  @empty($list)
    @include('admin::master.shared.content-item-form')
  @else
    @include('admin::master.shared.content-list-form')
  @endempty
@endsection


@push('scripts')
  <script>
    // $(document).Toasts('create', {
    //   title: 'Toast Title',
    //   autohide: true,
    //   delay: 750,
    //   body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    // })
  </script>
@endpush
