<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>HS Store</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/darkmode.css') }}">

    <!-- Fonts + Bootstrap + Icons + AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #007bff;
            --accent-color: #ffd500;
            --bg-light: #f7f9fc;
            --bg-dark: #0f172a;
            --text-dark: #222;
            --text-light: #eee;
        }

        [data-theme="dark"] {
            --bg-light: #0f172a;
            --text-dark: #eee;
            --text-light: #bbb;
            --primary-color: #1e90ff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            transition: all 0.3s ease-in-out;
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 74, 173, 0.95);
            backdrop-filter: blur(12px);
            transition: all 0.4s ease-in-out;
        }

        .navbar.scrolled {
            background: linear-gradient(90deg, #004aad, #007bff);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand img {
            height: 42px;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.25s;
        }

        .navbar .nav-link:hover {
            color: var(--accent-color) !important;
        }

        /* Search Bar */
        .search-bar .form-control {
            border-radius: 25px 0 0 25px;
            border: none;
        }

        .search-bar .btn {
            border-radius: 0 25px 25px 0;
            background: var(--accent-color);
            color: #000;
            transition: 0.2s;
        }

        .search-bar .btn:hover {
            background: #ffc107;
        }

        /* Cart */
        .btn-cart {
            background: #fff;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: 0.3s;
        }

        .btn-cart:hover {
            background: var(--accent-color);
        }

        .badge {
            background: #ff3333;
            font-size: 0.7rem;
        }

        /* Hero */
        .hero-section {
            margin-top: 80px;
        }

        .carousel-item img {
            border-radius: 20px;
            object-fit: cover;
            height: 450px;
            width: 100%;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.55);
            border-radius: 12px;
            padding: 1rem 2rem;
        }

        /* Features */
        .features {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            padding: 30px 20px;
            margin-top: -40px;
            position: relative;
            z-index: 2;
        }

        .features i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            background: linear-gradient(180deg, #111827, #0f172a);
            color: var(--text-light);
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
            color: var(--accent-color);
        }

        /* Scroll top */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 25px;
            background: var(--primary-color);
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

        /* Dark mode toggle */
        .theme-toggle {
            border: none;
            background: transparent;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            margin-left: 10px;
        }

        .theme-toggle:hover {
            color: var(--accent-color);
        }

        /* Sửa lỗi chữ bị lệch / che trong banner khi dark mode */
        [data-theme="dark"] .carousel-caption {
            position: relative;
            z-index: 2;
            /* đẩy caption lên trên lớp phủ */
            background: rgba(0, 0, 0, 0.55);
            /* vẫn giữ hiệu ứng tối nhẹ */
            color: #fff !important;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.8);
        }

        [data-theme="dark"] .carousel-item::before {
            background: rgba(0, 0, 0, 0.3);
            /* giảm độ tối nền xuống */
        }

        .carousel-caption {
            position: absolute;
            bottom: 30px;
            /* đồng bộ vị trí với dark mode */
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.55);
            border-radius: 12px;
            padding: 1rem 2rem;
            color: #fff;
            text-align: center;
            z-index: 2;
        }

        /* ======================= 🔍 SEARCH BAR CHUẨN ======================= */
        .search-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 420px;
            height: 42px;
        }

        .search-bar .form-control {
            height: 42px;
            border: none;
            outline: none;
            padding: 0 15px;
            font-size: 0.95rem;
            border-radius: 21px 0 0 21px;
            background: #fff;
            color: #111;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
        }

        .search-bar .form-control:focus {
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.3);
        }

        .search-bar .btn {
            height: 42px;
            width: 42px;
            border-radius: 0 21px 21px 0;
            background: var(--accent-color);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .search-bar .btn i {
            font-size: 1.1rem;
        }

        .search-bar .btn:hover {
            background: #ffc107;
        }

        /* 🌙 DARK MODE SEARCH */
        [data-theme="dark"] .search-bar .form-control {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: none;
        }

        [data-theme="dark"] .search-bar .form-control::placeholder {
            color: #94a3b8;
        }

        [data-theme="dark"] .search-bar .btn {
            background: #60a5fa;
            color: #fff;
        }

        [data-theme="dark"] .search-bar .btn:hover {
            background: #3b82f6;
        }

        /* ======================= 🛒 NÚT GIỎ HÀNG CHUẨN ======================= */
        .btn-cart {
            background: #fff;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-left: 10px;
            color: #000;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.25s ease;
        }

        .btn-cart i {
            font-size: 1.2rem;
            line-height: 0;
        }

        .btn-cart:hover {
            background: var(--accent-color);
            color: #000;
        }

        /* 🌙 DARK MODE GIỎ HÀNG */
        [data-theme="dark"] .btn-cart {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        [data-theme="dark"] .btn-cart:hover {
            background: #60a5fa;
            color: #fff;
        }

        /* 🩸 HUY HIỆU SỐ LƯỢNG GIỎ HÀNG */
        .btn-cart .badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #ff3333;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            line-height: 1;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        /* 🌙 DARK MODE BADGE */
        [data-theme="dark"] .btn-cart .badge {
            background: #f87171;
            box-shadow: 0 0 6px rgba(255, 0, 0, 0.4);
        }
    </style>
</head>

<body data-theme="light">

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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('homepage') }}"><i
                                class="bi bi-house-door"></i> Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Giới thiệu</a></li>
                    <li class="nav-item dropdown"><x-category-menu></x-category-menu></li>
                    <li class="nav-item dropdown"><x-brand-menu></x-brand-menu></li>
                </ul>

                <form action="{{ route('client.products.search') }}" method="GET" class="d-flex search-bar me-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..." required>
                    <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <a class="btn-cart me-3 position-relative" href="{{ route('cartshow') }}">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="badge position-absolute top-0 start-100 translate-middle"
                        id="cartCount">{{ count(Session::get('cart', [])) }}</span>
                </a>

                <button id="themeToggle" class="theme-toggle"><i class="bi bi-moon"></i></button>

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

    <!-- Hero Section -->
    @if (Request::route()->getName() == 'homepage')
        <section class="hero-section container mt-5" data-aos="fade-up">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 shadow">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/banner/banner1.png') }}" class="d-block w-100" alt="Banner 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>🔥 Khuyến mãi siêu hot!</h2>
                            <p>Giảm giá tới 40% cho Laptop Gaming tuần này!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/banner/banner2.png') }}" class="d-block w-100" alt="Banner 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>🎧 Tai nghe chính hãng</h2>
                            <p>Trải nghiệm âm thanh đỉnh cao – giá siêu ưu đãi!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <main class="container py-5" data-aos="fade-up" data-aos-delay="100">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-5 text-center">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white mb-3">HS Store</h5>
                    <p class="text-light small">Cung cấp sản phẩm công nghệ chính hãng – uy tín – giá tốt nhất Việt
                        Nam.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white mb-3">Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-warning">Chính sách bảo hành</a></li>
                        <li><a href="#" class="text-warning">Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-warning">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-md-end mb-4 text-center">
                    <h5 class="fw-bold text-white mb-3">Kết nối</h5>
                    <div class="social-icons">
                        <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://zalo.me" target="_blank"><i class="bi bi-chat-dots-fill"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-light opacity-25">
            <div class="text-center small text-secondary">© 2025 Hoài Sung Shop. All rights reserved.</div>
        </div>
    </footer>

    <button class="scroll-top" id="scrollTopBtn"><i class="bi bi-arrow-up"></i></button>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        const themeToggle = document.getElementById('themeToggle');
        const html = document.body;
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) html.dataset.theme = savedTheme;
        themeToggle.innerHTML = savedTheme === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        themeToggle.addEventListener('click', () => {
            html.dataset.theme = html.dataset.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', html.dataset.theme);
            themeToggle.innerHTML = html.dataset.theme === 'dark' ? '<i class="bi bi-sun"></i>' :
                '<i class="bi bi-moon"></i>';
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('.navbar');
            nav.classList.toggle('scrolled', window.scrollY > 50);
            document.getElementById('scrollTopBtn').style.display = window.scrollY > 300 ? 'flex' : 'none';
        });

        document.getElementById('scrollTopBtn').addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // 🧁 Toast khi thêm giỏ hàng (sẽ dùng lại ở detail page)
        window.showToast = (msg, icon = 'success') => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: msg,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        };
    </script>

    @stack('scripts')
    <script></script>

</body>

</html>
