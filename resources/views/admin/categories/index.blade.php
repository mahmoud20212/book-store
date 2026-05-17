@extends('theme.default')

@section('heading', 'عرض التصنيفات')

@section('content')
  <a href="{{ route('categories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i>  أضف تصنيفاً جديداً
  </a>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <table id="categories-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>العنوان</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
            <tr>
              <td>{{ $category->name }}</td>
              <td>{{ $category->description }}</td>
              <td>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i> تعديل
                </a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="post" class="d-inline-block">
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
      $('#categories-table').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
        }
      });
    });
  </script>
@endsection