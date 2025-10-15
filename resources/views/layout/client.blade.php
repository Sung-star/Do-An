<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>HS Store</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts + Bootstrap + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #222;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #004aad, #007bff);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease-in-out;
        }

        .navbar.scrolled {
            background: #004aad !important;
        }

        .navbar-brand img {
            height: 42px;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.2s;
        }

        .navbar .nav-link:hover {
            color: #ffd500 !important;
        }

        .search-bar .form-control {
            border-radius: 25px 0 0 25px;
            border: none;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-bar .btn {
            border-radius: 0 25px 25px 0;
            background: #ffd500;
            color: #000;
            border: none;
            transition: background 0.2s;
        }

        .search-bar .btn:hover {
            background: #ffc107;
        }

        .btn-cart {
            background: #fff;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .btn-cart:hover {
            background: #ffd500;
        }

        .badge {
            background: #ff3333;
            font-size: 0.7rem;
        }

        /* ✅ Banner tĩnh */
        .home-banner {
            margin-top: 100px;
            margin-bottom: 40px;
        }

        .home-banner img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease-in-out;
        }

        .home-banner img:hover {
            transform: scale(1.02);
        }

        /* Footer */
        footer {
            background: linear-gradient(180deg, #111827, #0f172a);
            color: #ccc;
            padding: 2rem 0;
        }

        footer h5 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        footer a {
            color: #aaa;
            text-decoration: none;
        }

        footer a:hover {
            color: #ffd500;
        }

        footer .social-icons a {
            color: #fff;
            font-size: 1.3rem;
            margin: 0 10px;
            transition: color 0.3s;
        }

        footer .social-icons a:hover {
            color: #ffd500;
        }

        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 25px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            cursor: pointer;
            display: none;
        }

        .scroll-top:hover {
            background: #0056d2;
        }
        footer {
    background: #1e1e1e;
    color: #ccc;
}

footer h5 {
    color: #fff;
}

footer a:hover {
    color: #ffd500 !important;
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
                <img src="{{ asset('images/logo.png') }}" alt="HS Logo">
                <span class="ms-2 text-white fw-bold fs-5">HS Store</span>
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('homepage') }}"><i class="bi bi-house-door"></i> Trang
                            chủ</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Giới thiệu</a></li>
                    <li class="nav-item dropdown"><x-category-menu></x-category-menu></li>
                    <li class="nav-item dropdown"><x-brand-menu></x-brand-menu></li>
                </ul>

                <!-- Search -->
                <form action="{{ route('client.products.search') }}" method="GET" class="d-flex search-bar me-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..." required>
                    <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <!-- Cart -->
                <a class="btn-cart me-3" href="{{ route('cartshow') }}">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle">
                        {{ count(Session::get('cart', [])) }}
                    </span>
                </a>

                <!-- User -->
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Hồ sơ của tôi</a></li>
                                <li><a class="dropdown-item" href="#">Đơn hàng của tôi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i
                                                class="bi bi-box-arrow-right"></i> Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link text-white"><i class="bi bi-person"></i> Đăng
                                nhập</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Banner tĩnh thay thế carousel -->
    @if (Request::route()->getName() == 'homepage')
        <section class="home-banner text-center">
            <div class="container">
                <img src="{{ asset('storage/banner/banner1.png') }}" alt="HS Store Banner">
            </div>
        </section>
    @endif

    <!-- Nội dung chính -->
    <main class="container py-5 mt-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <!-- Footer -->
<footer class="mt-5">
    <div class="container py-5">
        <div class="row">
            <!-- Cột 1: Giới thiệu -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-white mb-3">HS Store</h5>
                <p class="text-light small">
                    Website thương mại điện tử cung cấp sản phẩm công nghệ chính hãng, 
                    dịch vụ nhanh chóng và giá cả hợp lý.
                </p>
            </div>

            <!-- Cột 2: Hỗ trợ -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-white mb-3">Hỗ trợ</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-warning text-decoration-none">Chính sách bảo hành</a></li>
                    <li><a href="#" class="text-warning text-decoration-none">Chính sách đổi trả</a></li>
                    <li><a href="#" class="text-warning text-decoration-none">Câu hỏi thường gặp</a></li>
                </ul>
            </div>

            <!-- Cột 3: Mạng xã hội -->
            <div class="col-md-4 text-md-end mb-4 text-center">
                <h5 class="fw-bold text-white mb-3">Kết nối với chúng tôi</h5>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" class="text-white me-3 fs-4"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank" class="text-white me-3 fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="https://zalo.me" target="_blank" class="text-white fs-4"><i class="bi bi-chat-dots-fill"></i></a>
                </div>
            </div>
        </div>

        <hr class="border-light opacity-25">

        <div class="text-center small text-secondary">
            © 2025 Hoài Sung Shop. All rights reserved.
        </div>
    </div>
</footer>


    <!-- Scroll top -->
    <button class="scroll-top" id="scrollTopBtn"><i class="bi bi-arrow-up"></i></button>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
</body>

</html>
