<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مكتبة حسوب</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f0f0f0;
        }

        .score {
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .score-wrap {
            display: inline-block;
            position: relative;
            height: 19px;
        }

        .score .stars-active {
            color: #ffc107;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }
        
        .score .stars-inactive {
            color: lightgray;
            position: absolute;
            top: 0;
            left: 0;
        }

        .rating {
            overflow: hidden;
            display: inline-block;
            position: relative;
            font-size: 20px;
            color: #ffc107;
        }

        .rating-star {
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }

        .rating-star:after {
            position: relative;
            content: "\f005";
            font-family: "Font Awesome 7 Free";
            font-weight: 900;
            color: lightgray;
        }

        .rating-star.checked ~ .rating-star:after,
        .rating-star.checked:after {
            content: "\f005";
            color: #ffc107;
        }

        .rating:hover .rating-star:after {
            content: "\f005";
            color: lightgray;
        }

        .rating-star:hover ~ .rating-star:after,
        .rating .rating-star:hover:after {
            content: "\f005";
            color: #ffc107;
        }
    </style>

    @yield('head')
</head>

<body style="text-align: right;">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">مكتبة حسوب</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('cart.view') }}">
                                @if (auth()->user()->booksInCart()->count() > 0)
                                    <span class="badge bg-secondary">{{ auth()->user()->booksInCart()->count() }}</span>
                                @else
                                    <span class="badge bg-secondary">0</span>
                                @endif
                                سلة التسوق
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('gallery.categories.index') }}">
                            التصنيفات
                            <i class="fas fa-list"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('gallery.publishers.index') }}">
                            الناشرون
                            <i class="fas fa-table"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('gallery.authors.index') }}">
                            المؤلفون
                            <i class="fas fa-pen"></i>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('my.products') }}">
                                مشترياتي
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav mr-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">تسجيل</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown justify-content-left">
                            <a href="#" id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle object-fit-cover" width="40" height="40" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-left text-right mt-2">
                                <ul class="list-group list-group-flush pe-0">
                                    @can('update-books')
                                        <li class="list-group-item px-3 py-2">
                                            <a href="{{ route('admin.index') }}" class="text-decoration-none text-dark">لوحة الإدارة</a>
                                        </li>
                                    @endcan
                                    <li class="list-group-item px-3 py-2">
                                        <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark {{ request()->routeIs('profile.show') ? 'fw-bold' : '' }}">الملف الشخصي</a>
                                    </li>
                                    <li class="list-group-item px-3 py-2">
                                        <form action="{{ route('logout') }}" method="post" x-data>
                                            @csrf
                                            <button type="submit" class="btn btn-link text-decoration-none text-dark p-0">تسجيل الخروج</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>