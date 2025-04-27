@extends('admin::layouts.master')

@push('styles')
  <link rel="stylesheet" href="{{ url('/modules/Admin/Public/master/plugins/dropzone/min/dropzone.min.css') }}">
  <style>
    .note-editor.card {
      margin-bottom: 0;
    }
  </style>
@endpush


@section('content')
  @empty($list)
    @include('admin::master.shared.meta-item-form')
  @else
    @include('admin::master.shared.meta-list-form')
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
