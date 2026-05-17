@extends('theme.default')

@section('heading', 'تعديل تصنيف')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 mb-4">
    <div class="card">
      <div class="card-header text-right">
        عدل بيانات التصنيف
      </div>
      <div class="card-body">
      <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row form-group">
          <label for="name" class="col-md-4 col-form-label text-md-right">اسم التصنيف</label>
          <div class="col-md-6">
            <input
              type="text"
              id="name"
              name="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ $category->name }}"
              autocomplete="name"
              autofocus
            >
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="row form-group">
          <label for="description" class="col-md-4 col-form-label text-md-right">الوصف</label>
          <div class="col-md-6">
            <textarea 
              name="description"
              id="description"
              class="form-control @error('description') is-invalid @enderror"
              autocomplete="description"
              >{{ old('description', $category->description) }}</textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="form-group row mb-0">
          <div class="col-md-1">
            <button type="submit" class="btn btn-primary">عدل</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection