@extends('layout.app')

@section('title', 'Giới thiệu về Hoài Sung Shop')

@section('description')
    Tìm hiểu về Hoài Sung Shop - Cửa hàng thương mại điện tử uy tín với hơn
    {{ date('Y') - $companyData['founded'] }} năm kinh nghiệm
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-bg: #f8f9fa;
        }

        .hero-about {
            background: linear-gradient(135deg, var(--primary-color) 0%, #34495e 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
            border-top: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .value-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            text-align: center;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--success-color));
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color), var(--success-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 1.5rem;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--secondary-color);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            width: 20px;
            height: 20px;
            background: var(--secondary-color);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 0;
            }

            .timeline-item::before {
                left: 0;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right">
                        <h1 class="display-4 fw-bold mb-4">Về {{ $companyData['name'] }}</h1>
                        <p class="lead mb-4">{{ $companyData['description'] }}</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar3 me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-0">Thành lập</h6>
                                        <span>{{ $companyData['founded'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-0">Nhân viên</h6>
                                        <span>{{ $companyData['employees'] }}+ người</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="{{ route('about.team') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-people me-2"></i>Đội Ngũ
                            </a>
                            <a href="{{ route('about.contact') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-envelope me-2"></i>Liên Hệ
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center" data-aos="fade-left">
                        <i class="bi bi-shop" style="font-size: 10rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
