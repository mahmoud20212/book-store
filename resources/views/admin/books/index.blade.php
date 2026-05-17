@extends('theme.default')

@section('heading', 'عرض الكتاب')

@section('content')
  <a href="{{ route('books.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i>  أضف كتاباً جديداً
  </a>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <table id="books-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>العنوان</th>
            <th>الرقم التسلسلي</th>
            <th>التصنيف</th>
            <th>المؤلفون</th>
            <th>الناشر</th>
            <th>السعر</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($books as $book)
            <tr>
              <td><a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a></td>
              <td>{{ $book->isbn }}</td>
              <td>{{ $book->category != null ? $book->category->name : '' }}</td>
              <td>
                @if ($book->authors()->count() > 0)
                  @foreach ($book->authors as $author)
                    {{ $loop->first ? '' : 'و' }}
                    {{ $author->name }}
                  @endforeach
                @endif
              </td>
              <td>{{ $book->publisher != null ? $book->publisher->name : '' }}</td>
              <td>{{ $book->price }} $</td>
              <td>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i> تعديل
                </a>
                <form action="{{ route('books.destroy', $book->id) }}" method="post" class="d-inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                    <i class="fa fa-trash"></i> حذف
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>

      </table>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      $('#books-table').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
        }
      });
    });
  </script>
@endsection