<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Admin')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icons & Fonts -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ================= CUSTOM CSS ================= -->
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --danger: #e74a3b;
            --warning: #f6c23e;
            --light: #f8f9fc;
            --dark: #2c3e50;
        }

        body {
            background-color: var(--light);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            font-size: 0.95rem;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #4e73df, #224abe);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }

        .navbar input[type="text"] {
            border-radius: 8px 0 0 8px;
            border: none;
        }

        .navbar .btn-primary {
            border-radius: 0 8px 8px 0;
            background-color: var(--success);
            border: none;
        }

        /* Sidebar */
        .sb-sidenav-dark {
            background-color: var(--dark);
            transition: all 0.3s ease;
        }

        .sb-sidenav-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: #cfd8dc;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
        }

        .sb-sidenav-menu .nav-link:hover {
            background-color: #34495e;
            color: #fff;
        }

        .sb-sidenav-menu .nav-link.active {
            background-color: var(--primary);
            color: #fff;
        }

        .sb-sidenav-footer {
            color: #cfd8dc;
            font-size: 0.85rem;
            border-top: 1px solid #3b4a59;
            padding: 14px;
        }

        /* Main content */
        .container-fluid {
            padding: 20px 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        footer {
            background-color: #fff;
            border-top: 1px solid #ddd;
            box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #a5a5a5;
            border-radius: 4px;
        }

        /* 🌙 DARK MODE */
        body.dark-mode {
            background-color: #1e1e2f;
            color: #f0f0f0;
        }

        body.dark-mode .navbar {
            background: linear-gradient(90deg, #1b1f3b, #10121f);
        }

        body.dark-mode .sb-sidenav-dark {
            background-color: #151626;
        }

        body.dark-mode .sb-sidenav-menu .nav-link {
            color: #b0b3c2;
        }

        body.dark-mode .sb-sidenav-menu .nav-link:hover {
            background-color: #2c2f47;
            color: #fff;
        }

        body.dark-mode .sb-sidenav-menu .nav-link.active {
            background-color: #4e73df;
            color: #fff;
        }

        /* ✅ FIX FOOTER */
        body.dark-mode footer {
            background-color: #1b1e2d !important;
            color: #ccc !important;
            border-top: 1px solid #333;
        }

        body.dark-mode footer a {
            color: #4e9cff !important;
        }

        /* ✅ FIX TABLE & TEXT */
        body.dark-mode table {
            background-color: #2a2e40 !important;
            color: #f0f0f0 !important;
        }

        body.dark-mode thead {
            background-color: #3b3f54 !important;
            color: #fff !important;
        }

        body.dark-mode tbody tr:hover {
            background-color: #343a50 !important;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode label,
        body.dark-mode th,
        body.dark-mode td,
        body.dark-mode a,
        body.dark-mode li {
            color: #f0f0f0 !important;
        }

        body.dark-mode a:hover {
            color: #4e73df !important;
        }

        /* ✅ FIX FORM INPUTS */
        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background-color: #2a2e40 !important;
            color: #f0f0f0 !important;
            border: 1px solid #444 !important;
        }

        body.dark-mode .card {
            background-color: #26293e;
            color: #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .btn-light {
            background-color: #3c3f53 !important;
            color: #f0f0f0 !important;
        }

        body.dark-mode .btn-outline-dark {
            color: #f0f0f0 !important;
            border-color: #666 !important;
        }

        body.dark-mode .swal2-popup {
            background-color: #2a2e40 !important;
            color: #f0f0f0 !important;
        }

        /* ===== DARK MODE – TABLE FIXES (ghi đè mạnh) ===== */
        body.dark-mode .table {
            background-color: #2a2e40 !important;
            color: #f1f1f1 !important;
            border-color: #3e435a !important;
        }

        /* header của bảng: luôn nền tối + chữ sáng, bất kể .table-light/.table-primary */
        body.dark-mode .table thead,
        body.dark-mode .table thead tr,
        body.dark-mode .table thead th {
            background-color: #2f3348 !important;
            color: #ffffff !important;
            border-color: #4a4f6a !important;
            opacity: 1 !important;
            /* vô hiệu hoá các class opacity-x */
        }

        /* nếu bạn dùng .table-primary/.table-light cho thead */
        body.dark-mode .table-primary {
            background-color: #2f3b78 !important;
            color: #ffffff !important;
        }

        body.dark-mode .table-light {
            background-color: #2f3348 !important;
            color: #ffffff !important;
        }

        /* sọc của .table-striped trong dark mode */
        body.dark-mode .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #262a3d !important;
            color: inherit !important;
        }

        /* viền ô */
        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #3e435a !important;
        }

        /* utility thường làm chữ mờ ở header/footer */
        body.dark-mode .text-secondary {
            color: #d0d3e2 !important;
        }

        body.dark-mode .opacity-50,
        body.dark-mode .opacity-75 {
            opacity: 1 !important;
        }

        /* ===== DARK MODE PAGINATION FIX ===== */
        body.dark-mode .pagination {
            --bs-pagination-bg: #2a2e40;
            --bs-pagination-border-color: #3e435a;
            --bs-pagination-color: #f0f0f0;
            --bs-pagination-hover-bg: #3a3f55;
            --bs-pagination-hover-color: #ffffff;
            --bs-pagination-active-bg: #4e73df;
            --bs-pagination-active-border-color: #4e73df;
            --bs-pagination-active-color: #ffffff;
            --bs-pagination-disabled-bg: #1e1e2f;
            --bs-pagination-disabled-color: #777;
        }

        /* Nếu bạn có dùng .page-item hoặc .page-link riêng */
        body.dark-mode .page-item .page-link {
            background-color: #2a2e40 !important;
            color: #f0f0f0 !important;
            border: 1px solid #3e435a !important;
        }

        body.dark-mode .page-item.active .page-link {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
            color: #fff !important;
        }

        body.dark-mode .page-item:hover .page-link {
            background-color: #3a3f55 !important;
            color: #fff !important;
        }

        body.dark-mode .page-item.disabled .page-link {
            background-color: #1e1e2f !important;
            color: #777 !important;
            border-color: #333 !important;
        }

        .card-stats {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-stats:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .card-stats i {
            font-size: 2rem;
            opacity: 0.8;
        }

        /* 🌙 Fix chữ dropdown menu bị mờ trong Dark Mode */
        body.dark-mode .dropdown-menu {
            background-color: #2a2e40 !important;
            /* nền tối vừa mắt */
            color: #f0f0f0 !important;
            /* chữ sáng */
            border: 1px solid #3a3f54 !important;
        }

        body.dark-mode .dropdown-menu .dropdown-item {
            color: #f0f0f0 !important;
            /* màu chữ sáng */
        }

        body.dark-mode .dropdown-menu .dropdown-item:hover,
        body.dark-mode .dropdown-menu .dropdown-item:focus {
            background-color: #3a3f54 !important;
            /* hover tối nhẹ */
            color: #fff !important;
            /* chữ trắng khi hover */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <a class="navbar-brand ps-3" href="{{ route('homepage') }}">My Admin</a>

        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm me-4 me-lg-0 text-white" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="ms-auto d-flex align-items-center">
            <!-- Search -->
            <form class="d-none d-md-inline-block form-inline me-3">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Tìm kiếm..." aria-label="Search..." />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Dark Mode -->
            <button id="themeToggle" class="btn btn-sm btn-outline-light me-2" title="Đổi giao diện">
                <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            </button>

            <!-- User Dropdown -->
            <ul class="navbar-nav ms-auto me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('ad.changepass.form') }}"><i
                                    class="bi bi-lock-fill me-2"></i>Đổi mật khẩu</a></li>
                        <li>
                            <form action="{{ route('ad.logout') }}" method="post" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item"><i
                                        class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar + Content -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark shadow-sm" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav mt-3">
                        <a class="nav-link" href="{{ route('ad.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ route('cate2.index') }}">
                            <i class="fas fa-tags"></i> <span>Loại sản phẩm</span>
                        </a>
                        <a class="nav-link" href="{{ route('brand2.index') }}">
                            <i class="fas fa-building"></i> <span>Thương hiệu</span>
                        </a>
                        <a class="nav-link" href="{{ route('pro2.index') }}">
                            <i class="fas fa-box"></i> <span>Sản phẩm</span>
                        </a>
                        <a class="nav-link" href="{{ route('ad.customers.index') }}">
                            <i class="fas fa-users"></i> <span>Khách hàng</span>
                        </a>
                        <a class="nav-link" href="{{ route('ad.orders.index') }}">
                            <i class="fas fa-receipt"></i> <span>Đơn hàng</span>
                        </a>
                        <hr class="sidebar-divider">
                        <a class="nav-link" href="{{ route('user.index') }}">
                            <i class="fas fa-user-cog"></i> <span>Người dùng</span>
                        </a>
                    </div>
                </div>

                <div class="sb-sidenav-footer text-center">
                    <div class="small">Đăng nhập bởi:</div>
                    <strong>{{ Auth::check() ? Auth::user()->fullname : 'Guest' }}</strong>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                @yield('content')
            </main>

            <!-- ✅ FOOTER -->
            <footer class="py-4 mt-auto footer">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div>Copyright &copy; My Admin 2025</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- SweetAlert -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- ✅ Dark Mode Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const toggleBtn = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');

            // Load theme preference
            if (localStorage.getItem('theme') === 'dark') {
                body.classList.add('dark-mode');
                icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
            }

            toggleBtn.addEventListener('click', () => {
                body.classList.toggle('dark-mode');

                if (body.classList.contains('dark-mode')) {
                    icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                    localStorage.setItem('theme', 'dark');
                } else {
                    icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
