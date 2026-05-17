@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        عرض تفاصيل الكتاب
                    </div>
                    <div class="card-body">
                        <table class="table">
                            @auth
                                <div class="form text-center mb-2">
                                    <input type="hidden" id="book_id" value="{{ $book->id }}">
                                    <span class="text-muted mb-3">
                                        <input type="number" class="form-control d-inline mx-auto" id="quantity" name="quantity"
                                            value="1" min="1" max="{{ $book->number_of_copies }}" style="width: 100px;"
                                            required>
                                    </span>
                                    <button type="submit" class="btn btn-warning addCart me-2">
                                        أضف إلى السلة
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            @endauth
                            <tr>
                                <th>العنوان</th>
                                <td class="lead"><b>{{ $book->title }}</b></td>
                            </tr>
                            @if ($book->isbn)
                                <tr>
                                    <th>الرقم التسلسلي</th>
                                    <td>{{ $book->isbn }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>صورة الغلاف</th>
                                <td><img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="img-fluid img-thumbnail"></td>
                            </tr>
                            @if ($book->category)
                                <tr>
                                    <th>التصنيف</th>
                                    <td>{{ $book->category->name }}</td>
                                </tr>
                            @endif
                            @if ($book->authors()->count() > 0)
                                <tr>
                                    <th>المؤالفون</th>
                                    <td>
                                        @foreach ($book->authors as $author)
                                            {{ $loop->first ? '' : 'و' }}
                                            {{ $author->name }}
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                            @if ($book->publisher)
                                <tr>
                                    <th>الناشر</th>
                                    <td>{{ $book->publisher->name }}</td>
                                </tr>
                            @endif
                            @if ($book->description)
                                <tr>
                                    <th>الوصف</th>
                                    <td>{{ $book->description }}</td>
                                </tr>
                            @endif
                            @if ($book->publish_year)
                                <tr>
                                    <th>سنة النشر</th>
                                    <td>{{ $book->publish_year }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>عدد الصفحات</th>
                                <td>{{ $book->number_of_pages }}</td>
                            </tr>
                            <tr>
                                <th>عدد النسخ</th>
                                <td>{{ $book->number_of_copies }}</td>
                            </tr>
                            <tr>
                                <th>السعر</th>
                                <td>{{ $book->price }} $</td>
                            </tr>
                            <tr>
                                <th>التقييم</th>
                                <td>
                                    <span class="score">
                                        <div class="score-wrap">
                                            <span class="stars-active" style="width: {{ $book->rate() * 20 }}%">
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                            </span>
                                            <span class="stars-inactive">
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                                <i class="fa fa-star star"></i>
                                            </span>
                                        </div>
                                    </span>
                                    <span class="ms-2">عدد المقيمين ({{ $book->ratings()->count() }}) مستخدم</span>
                                </td>
                            </tr>
                        </table>
                        @auth
                            <h4 class="mb-3">قيم هذا الكتاب</h4>
                            @if($bookfind)
                                @if (auth()->user()->rated($book))
                                    <div class="rating">
                                        <span class="rating-star {{auth()->user()->bookRating($book)->value == 5 ? 'checked' : ''}}"
                                            data-value="5"></span>
                                        <span class="rating-star {{auth()->user()->bookRating($book)->value == 4 ? 'checked' : ''}}"
                                            data-value="4"></span>
                                        <span class="rating-star {{auth()->user()->bookRating($book)->value == 3 ? 'checked' : ''}}"
                                            data-value="3"></span>
                                        <span class="rating-star {{auth()->user()->bookRating($book)->value == 2 ? 'checked' : ''}}"
                                            data-value="2"></span>
                                        <span class="rating-star {{auth()->user()->bookRating($book)->value == 1 ? 'checked' : ''}}"
                                            data-value="1"></span>
                                    </div>
                                @else
                                    <div class="rating">
                                        <span class="rating-star" data-value="5"></span>
                                        <span class="rating-star" data-value="4"></span>
                                        <span class="rating-star" data-value="3"></span>
                                        <span class="rating-star" data-value="2"></span>
                                        <span class="rating-star" data-value="1"></span>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-danger mt-4" role="alert">
                                    يجب شراء الكتاب لتستطيع تقيمه
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
@endsection

    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addCartButtons = document.querySelectorAll('.addCart');
                addCartButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const bookId = document.getElementById('book_id').value;
                        const quantity = document.getElementById('quantity').value;

                        fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ id: bookId, quantity: quantity })
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                document.querySelector('span.badge').textContent = data.num_of_products;
                                var notyf = new Notyf();
                                notyf.success('تم إضافة الكتاب إلى السلة بنجاح!');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('حدث خطأ أثناء إضافة الكتاب إلى السلة. حاول مرة أخرى.');
                            });
                    });
                });
            });
        </script>
        <script>
            document.querySelectorAll('.rating-star').forEach(star => {
                star.addEventListener('click', function () {
                    const ratingValue = this.getAttribute('data-value');
                    fetch("{{ route('book.rate', $book->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ value: ratingValue })
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('تم تقييم الكتاب بنجاح!');
                                location.reload();
                            } else {
                                alert('حدث خطأ أثناء تقييم الكتاب. حاول مرة أخرى.');
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            alert('حدث خطأ أثناء تقييم الكتاب. حاول مرة أخرى.');
                        });
                });
            });
        </script>
    @endsection