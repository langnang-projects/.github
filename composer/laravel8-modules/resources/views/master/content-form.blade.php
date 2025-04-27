@extends('layouts.master')

@php
  if (!isset($content)) {
      $content = new \App\Models\Content([
          'id' => old('id'),
          'slug' => old('slug'),
          'title' => old('title'),
          'ico' => old('ico'),
          'description' => old('description'),
          'text' => old('text'),
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
        <h5 class="card-title mb-0">Content</h5>
      </div>
      <div class="card-body">
        @csrf
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
              value="{{ $content->title }}">
            @error('title')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="slug" value="{{ $content->slug }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ico</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="ico" value="{{ $content->ico }}">
          </div>
        </div>

        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Type</legend>
          <div class="col-sm-10">
            <div class="row @error('type') is-invalid @enderror">
              @foreach (\Arr::get($options, 'content.type') ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                      value="{{ $option['value'] }}" @if ($content->type == $option['value']) checked @endif>
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
              @foreach (\Arr::get($options, 'content.status') ?? [] as $option)
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
                      value="{{ $option['value'] }}" @if ($content->status == $option['value']) checked @endif>
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
            <textarea class="form-control" name="description" rows="2">{{ $content->description }}</textarea>
          </div>
        </div>
        <fieldset class="form-group row">
          <legend class="col-form-label col-sm-2 float-sm-left pt-0">Parent</legend>
          <div class="col-sm-10">
            <select class="form-control" name="parent">
              <option value="0">Choose...</option>
              @isset($contents)
                @foreach ($contents as $_content)
                  <option value="{{ $_content->id }}" class="d-flex align-items-center"
                    @if ($_content->id == $content->parent) selected @endif>
                    {{ $_content->status }} |
                    {{ $_content->type }} |
                    {{ $_content->title }}
                  </option>
                @endforeach
              @endisset
            </select>
          </div>
        </fieldset>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Text</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="text" rows="5">{{ $content->text }}</textarea>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <a type="submit" class="btn btn-danger mr-auto"
          href="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-content/' . $content->id) }}"
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
      action="{{ url((isset($attributes) ? $attributes['alias'] . '/' : 'home/') . 'delete-content/' . $content->id) }}"
      method="POST" class="d-none">
      @csrf
    </form>
  </div>
@endsection
