@props([
    'data' => [],
    'class' => null,
    'depth' => 3,
])
@php
  //   var_dump($class);
@endphp

<a href="#" {{ $attributes->class(['list-group-item', 'list-group-item-action', 'pl-' . $depth, $class]) }}>
  {{ $data['name'] }}
</a>


@isset($data['children'])
  @foreach ($data['children'] as $item)
    <x-bootstrap4.tree-group-item :data="$item" :class="$class" :depth="$depth + 1" />
  @endforeach
@endisset
