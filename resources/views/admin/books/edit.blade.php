@extends('theme.default')

@section('heading', 'تعديل كتاب')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 mb-4">
    <div class="card">
      <div class="card-header text-right">
        عدل بيانات الكتاب
      </div>
      <div class="card-body">
      <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row form-group">
          <label for="title" class="col-md-4 col-form-label text-md-right">عنوان الكتاب</label>
          <div class="col-md-6">
            <input
              type="text"
              id="title"
              name="title"
              class="form-control @error('title') is-invalid @enderror"
              value="{{ $book->title }}"
              autocomplete="title"
              autofocus
            >
            @error('title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="isbn" class="col-md-4 col-form-label text-md-right">الرقم التسلسلي (ISBN)</label>
          <div class="col-md-6">
            <input
              type="text"
              id="isbn"
              name="isbn"
              class="form-control @error('isbn') is-invalid @enderror"
              value="{{ $book->isbn }}"
              autocomplete="isbn"
            >
            @error('isbn')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="cover_image" class="col-md-4 col-form-label text-md-right">صورة الغلاف</label>
          <div class="col-md-6">
            <input
              type="file"
              onchange="readCoverImageURL(this)"
              id="cover_image"
              name="cover_image"
              class="form-control @error('cover_image') is-invalid @enderror"
              value="{{ old('cover_image') }}"
              autocomplete="cover_image"
              accept="image/*"
            >
            @error('cover_image')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror

            <img src="{{ asset('storage/' . $book->cover_image) }}" id="cover-image-thumb" class="img-fluid img-thumbnail" alt="">
          </div>
        </div>
        <div class="row form-group">
          <label for="category" class="col-md-4 col-form-label text-md-right">التصنيف</label>
          <div class="col-md-6">
            <select name="category" id="category" class="form-control">
              <option disabled {{ $book->category == null ? 'selected' : '' }}>اختر تصنيفاً</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $book->category == $category ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            @error('category')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="authors" class="col-md-4 col-form-label text-md-right">المؤلفون</label>
          <div class="col-md-6">
            <select name="authors[]" id="authors" class="form-control" multiple>
              <option disabled {{ $book->authors->isEmpty() ? 'selected' : '' }}>اختر المؤلفين</option>
              @foreach ($authors as $author)
                <option value="{{ $author->id }}" {{ $book->authors->contains($author) ? 'selected' : '' }}>
                  {{ $author->name }}
                </option>
              @endforeach
            </select>
            @error('authors')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="publisher" class="col-md-4 col-form-label text-md-right">الناشر</label>
          <div class="col-md-6">
            <select name="publisher" id="publisher" class="form-control">
              <option disabled {{ $book->publisher == null ? 'selected' : '' }}>اختر الناشر</option>
              @foreach ($publishers as $publisher)
                <option value="{{ $publisher->id }}" {{ $book->publisher == $publisher ? 'selected' : '' }}>
                  {{ $publisher->name }}
                </option>
              @endforeach
            </select>
            @error('publisher')
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
              >{{ $book->description }}</textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="publish_year" class="col-md-4 col-form-label text-md-right">سنة النشر</label>
          <div class="col-md-6">
            <input
              type="number"
              id="publish_year"
              name="publish_year"
              class="form-control @error('publish_year') is-invalid @enderror"
              value="{{ $book->publish_year }}"
              autocomplete="publish_year"
              autofocus
            >
            @error('publish_year')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="number_of_pages" class="col-md-4 col-form-label text-md-right">عدد الصفحات</label>
          <div class="col-md-6">
            <input
              type="number"
              id="number_of_pages"
              name="number_of_pages"
              class="form-control @error('number_of_pages') is-invalid @enderror"
              value="{{ $book->number_of_pages }}"
              autocomplete="number_of_pages"
              autofocus
            >
            @error('number_of_pages')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="number_of_copies" class="col-md-4 col-form-label text-md-right">عدد النسخ</label>
          <div class="col-md-6">
            <input
              type="number"
              id="number_of_copies"
              name="number_of_copies"
              class="form-control @error('number_of_copies') is-invalid @enderror"
              value="{{ $book->number_of_copies }}"
              autocomplete="number_of_copies"
              autofocus
            >
            @error('number_of_copies')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="row form-group">
          <label for="price" class="col-md-4 col-form-label text-md-right">السعر</label>
          <div class="col-md-6">
            <input
              type="number"
              id="price"
              name="price"
              class="form-control @error('price') is-invalid @enderror"
              value="{{ $book->price }}"
              autocomplete="price"
              autofocus
            >
            @error('price')
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

@section('script')
<script>
  function readCoverImageURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#cover-image-thumb').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection