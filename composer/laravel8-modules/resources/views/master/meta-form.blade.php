@extends('layouts.master')

@php
  if (!isset($meta)) {
      $meta = new \App\Models\Meta([
          'id' => old('id'),
          'slug' => old('slug'),
          'name' => old('name'),
          'ico' => old('ico'),
          'description' => old('description'),
          'type' => old('type'),
          'status' => old('status'),
          'parent' => old('parent'),
      ]);
  }
@endphp

@section('content')
  <div class="container py-3">
    <form class="card" method="POST">
      <div class="card-header">
        <h5 class="card-title mb-0">Meta</h5>
      </div>
      <div class="card-body">
        @csrf
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
              value="{{ $meta->name }}">
            @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="slug" value="{{ $meta->slug }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ico</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="ico" value="{{ $meta->ico }}">
          </div>
        </div>

        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Type</legend>
          <div class="col-sm-10">
            <div class="row @error('type') is-invalid @enderror">
              @foreach (\Arr::get($options, 'meta.type') ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                      value="{{ $option['value'] }}" @if ($meta->type == $option['value']) checked @endif>
                    <label class="form-check-label">
                      {{ $option['name'] }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            @error('type')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </fieldset>
        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Status</legend>
          <div class="col-sm-10">
            <div class="row @error('status') is-invalid @enderror">
              @foreach (\Arr::get($options, 'meta.status') ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
                      value="{{ $option['value'] }}" @if ($meta->status == $option['value']) checked @endif>
                    <label class="form-check-label">
                      {{ $option['name'] }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            @error('status')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </fieldset>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="description" rows="3">{{ $meta->description }}</textarea>
          </div>
        </div>
        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Parent</legend>
          <div class="col-sm-10">
            <select class="form-control" name="parent">
              <option value="0">Choose...</option>
              @isset($metas)
                @foreach ($metas as $_meta)
                  <option value="{{ $_meta->id }}" class="d-flex align-items-center"
                    @if ($_meta->id == $meta->parent) selected @endif>
                    {{ $_meta->status }} |
                    {{ $_meta->type }} |
                    {{ $_meta->name }}
                  </option>
                @endforeach
              @endisset
            </select>
          </div>
        </fieldset>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <a type="submit" class="btn btn-danger mr-auto"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-meta/' . $meta->id) }}"
          onclick="event.preventDefault();document.getElementById('destroy-form').submit();">destroy</a>
        <a href="{{ url(isset($attributes) ? $attributes['alias'] . '/' : 'home/') }}" role="button"
          class="btn ml-2 btn-secondary" data-dismiss="modal">Cancel</a>
        <div class="alert alert-danger my-0 d-none" name="delete-alert" role="alert" style="flex-grow: 1">
          确定要删除吗？
        </div>
        <button type="submit" class="btn ml-2 btn-primary">Confirm</button>
      </div>
    </form>
    <form id="destroy-form"
      action="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-meta/' . $meta->id) }}"
      method="POST" class="d-none">
      @csrf
    </form>
  </div>
@endsection
