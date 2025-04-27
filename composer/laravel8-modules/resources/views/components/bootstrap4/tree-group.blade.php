@props([
    'data' => [],
    'flush' => false,
    'class' => null,
    'itemClass' => null,
])
@php
  //   var_dump($itemClass);
@endphp

<div {{ $attributes->class(['list-group', 'list-group-flush' => $flush, $class]) }}>

  @foreach ($data as $item)
    <x-bootstrap4.tree-group-item :data="$item" :class="$itemClass" />
  @endforeach
</div>
