@extends('theme.default')

@section('heading', 'عرض المستخدمين')

@section('content')
  <a href="{{ route('users.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> أضف مستخدماً جديداً
  </a>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <table id="users-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>نوع المستخدم</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @if ($user->isSuperAdmin())
                  مشرف عام
                @elseif ($user->isAdmin())
                  مشرف
                @else
                  مستخدم عادي
                @endif
              <td>
                <form href="{{ route('users.update', $user->id) }}" class="ml-4 form-inline d-inline-block" method="post">
                  @csrf
                  @method('PATCH')
                  <select name="administration_level" class="form-control form-control-sm">
                    <option selected disabled>اختر نوعاً</option>
                    <option value="0">مستخدم عادي</option>
                    <option value="1">مشرف</option>
                    <option value="2">مشرف عام</option>
                  </select>
                  <button type="submit" class="btn btn-info btn-sm">
                    <i class="fa fa-edit"></i> تعديل
                  </button>
                </form>
                <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline-block">
                  @csrf
                  @method('DELETE')
                  @if (auth()->user()->id != $user->id)
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                      <i class="fa fa-trash"></i> حذف
                    </button>
                  @else
                    <div class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> حذف</div>
                  @endif
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