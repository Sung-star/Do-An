@extends('layout.app')

@section('title', 'Giới thiệu về HS Store')

@section('content')
    <style>
        /* ép màu thanh navbar cho đồng bộ trang chủ */
        .navbar {
            background-color: #0d47a1 !important;
        }

        .navbar .nav-link,
        .navbar .navbar-brand,
        .navbar .btn,
        .navbar a {
            color: white !important;
        }

        .navbar .nav-link:hover {
            color: #FFD700 !important;
            /* vàng nhạt khi hover */
        }

        :root {
            --primary-color: #007bff;
            --light-bg: #f8fafc;
        }

        /* Giữ đúng tone xanh như trang chủ */
        .hero-about {
            background: linear-gradient(135deg, var(--primary-color), #0d6efd);
            color: white;
            padding: 6rem 0 5rem;
            /* thêm khoảng cách để tránh dính navbar */
            text-align: center;
            position: relative;
        }

        .hero-about h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2.5rem;
        }

        /* Card thống kê */
        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }

        /* Card giá trị cốt lõi */
        .value-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.8rem;
            text-align: center;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .value-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        /* Dark mode */
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .value-card {
            background: #1e293b;
            color: #e2e8f0;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
        }

        [data-theme="dark"] .hero-about {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        /* Count-up effect */
        .counter {
            transition: 0.3s;
        }

        .hero-about {
            background: linear-gradient(135deg, #2196f3 0%, #0d47a1 100%);
            color: white;
            padding: 6rem 0 5rem;
            text-align: center;
            position: relative;
            transition: all 0.4s ease-in-out;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-about" data-aos="fade-down">
        <div class="container">
            <h1>Về {{ $companyData['name'] }}</h1>
            <p class="lead mt-3">{{ $companyData['description'] }}</p>
            <p><em>“{{ $companyData['mission'] }}”</em></p>
        </div>
    </section>

    <!-- Thống kê -->
    <section class="py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Thành tựu nổi bật</h2>
            <div class="row g-4">
                @foreach ($stats as $s)
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi {{ $s['icon'] }}"></i>
                            </div>
                            <div class="stat-number counter" data-target="{{ preg_replace('/[^0-9]/', '', $s['number']) }}">
                                0</div>
                            <p class="fw-semibold text-muted">{{ $s['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Giá trị cốt lõi -->
    <section class="py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Giá trị cốt lõi</h2>
            <div class="row g-4">
                @foreach ($values as $v)
                    <div class="col-md-4">
                        <div class="value-card">
                            <div class="value-icon">
                                <i class="bi {{ $v['icon'] }}"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $v['title'] }}</h5>
                            <p>{{ $v['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll(".counter");
            counters.forEach(counter => {
                const target = +counter.getAttribute("data-target");
                const speed = 200;
                const update = () => {
                    const value = +counter.innerText.replace(/\D/g, "");
                    const increment = Math.ceil(target / speed);
                    if (value < target) {
                        counter.innerText = value + increment;
                        setTimeout(update, 15);
                    } else {
                        counter.innerText = target.toLocaleString() + "+";
                    }
                };
                update();
            });
        });
    </script>
@endsection
