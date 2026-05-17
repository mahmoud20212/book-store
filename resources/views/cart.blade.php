@extends('layouts.main')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">سلة التسوق</div>
        <div class="card-body">
          @if ($items->count())
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">العنوان</th>
                <th scope="col">السعر</th>
                <th scope="col">الكمية</th>
                <th scope="col">السعر الكلي</th>
                <th scope="col"></th>
              </tr>
            </thead>
            @php($totalPrice = 0)
            @foreach ($items as $item)
            @php($totalPrice += $item->price * $item->pivot->number_of_copies)
            <tbody>
              <tr>
                <th scope="row">{{ $item->title }}</th>
                <td>{{ $item->price }}$</td>
                <td>{{ $item->pivot->number_of_copies }}</td>
                <td>{{ $item->price * $item->pivot->number_of_copies }}$</td>
                <td>
                  <form method="post" style="float: left; margin: auto 5px;"
                    action="{{ route('cart.remove_all', $item->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">إزالة الكل</button>
                  </form>
                  <form method="post" style="float: left; margin: auto 5px;"
                    action="{{ route('cart.remove_one', $item->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">أزل واحداً</button>
                  </form>
                </td>
              </tr>
            </tbody>
            @endforeach
          </table>
          <div class="mt-3">
            <h4>السعر الإجمالي: {{ $totalPrice }}$</h4>
            <a href="{{ route('credit.checkout') }}" class="btn btn-warning my-3">
              <span>بطاقة الائتمان</span>
              <i class="fas fa-credit-card"></i>
            </a>
          </div>
        @else
          <h4>لا توجد كتب في سلة التسوق</h4>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection