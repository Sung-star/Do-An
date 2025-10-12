<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hoài Sung Shop</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts + Bootstrap + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
        }

        /* Navbar */
        .navbar {
            background-color: #0066ff;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            color: #ffcc00 !important;
        }

        .search-bar .form-control {
            border-radius: 20px 0 0 20px;
        }

        .search-bar .btn {
            border-radius: 0 20px 20px 0;
            background: #ffcc00;
            border: none;
        }

        /* Header */
        header.hero-section {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            padding: 3rem 0;
            text-align: center;
        }

        header.hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Footer */
        footer {
            background-color: #222;
            color: #ddd;
            padding: 2rem 0;
        }

        footer a {
            color: #ffcc00;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer .social-icons a {
            color: #fff;
            font-size: 1.3rem;
            margin: 0 10px;
        }

        footer .social-icons a:hover {
            color: #ffcc00;
        }

        .badge {
            background-color: #ffcc00;
            color: #000;
        }

        #mainCarousel {
            max-width: 1200px;
            /* giữ tỉ lệ ngang hợp lý như Lazada */
            margin: 0 auto;
            margin-top: 10px;
            /* căn giữa */
        }


       <style>
.carousel-inner img {
    width: 100%;
    height: 450px;             /* chiều cao cố định của banner */
    object-fit: cover;         /* lấp đầy khung, cắt phần thừa */
}
</style>

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Hoài Sung Shop">
                <span class="ms-2 text-white fw-bold">Hoài Sung Shop</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('homepage') }}"><i class="bi bi-house-door"></i>
                            Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Thông Tin</a></li>
                    <li class="nav-item dropdown"><x-category-menu></x-category-menu></li>
                    <li class="nav-item dropdown"><x-brand-menu></x-brand-menu></li>
                </ul>

                <!-- Search -->
                <form action="{{ route('client.products.search') }}" method="GET" class="d-flex search-bar me-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..." required>
                    <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <!-- Cart -->
                <a class="btn btn-light position-relative" href="{{ route('cartshow') }}">
                    <i class="bi bi-cart3"></i>
                    <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle">
                        {{ count(Session::get('cart', [])) }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    {{-- <!-- Header -->
    <header class="hero-section">
        <div class="container">
            <h1>🛍️ Shop đồ dùng công nghệ</h1>
            <p class="lead">Mua sắm dễ dàng – Trải nghiệm tuyệt vời!</p>
        </div>
    </header> --}}

    <!-- Banner Carousel -->
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('storage/banner/banner1.png') }}" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/banner/banner2.png') }}" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/banner/banner3.png') }}" class="d-block w-100" alt="Banner 3">
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <!-- Main Content -->
    <main class="container py-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Về Hoài Sung Shop</h5>
                    <p>Website thương mại điện tử cung cấp sản phẩm chính hãng, dịch vụ nhanh chóng và giá cả hợp lý.
                    </p>
                </div>

                <!-- Support -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-white">Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>

                <!-- Social -->
                <div class="col-md-4 text-center">
                    <h5 class="text-white">Kết nối với chúng tôi</h5>
                    <div class="social-icons">
                        <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://zalo.me" target="_blank"><i class="bi bi-chat-dots-fill"></i></a>
                    </div>
                </div>
            </div>

            <hr class="border-light">

            <div class="text-center">
                <p class="mb-0">© 2025 Hoài Sung Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
