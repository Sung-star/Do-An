@extends('layout.client')

@section('content')
    {{-- 🧭 BỘ LỌC SẢN PHẨM --}}
    <section class="py-3 border-bottom filter-bar">
        <div class="container">
            <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-center">
                {{-- Danh mục --}}
                <div class="col-auto">
                    <select name="cateid" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories ?? [] as $c)
                            <option value="{{ $c->cateid ?? $c->id }}"
                                {{ request('cateid') == ($c->cateid ?? $c->id) ? 'selected' : '' }}>
                                {{ $c->catename }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Thương hiệu --}}
                <div class="col-auto">
                    <select name="brandid" class="form-select" onchange="this.form.submit()">
                        <option value="">Tất cả thương hiệu</option>
                        @foreach ($brands ?? [] as $b)
                            <option value="{{ $b->id }}" {{ request('brandid') == $b->id ? 'selected' : '' }}>
                                {{ $b->brandname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Lọc theo giá --}}
                <div class="col-auto">
                    <select name="price_range" class="form-select" onchange="this.form.submit()">
                        <option value="">Khoảng giá</option>
                        <option value="0-1000000" {{ request('price_range') == '0-1000000' ? 'selected' : '' }}>Dưới 1 triệu
                        </option>
                        <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>
                            1 - 5 triệu</option>
                        <option value="5000000-10000000"
                            {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>5 - 10 triệu</option>
                        <option value="10000000-999999999"
                            {{ request('price_range') == '10000000-999999999' ? 'selected' : '' }}>Trên 10 triệu</option>
                    </select>
                </div>

                {{-- Sắp xếp --}}
                <div class="col-auto">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Sắp xếp theo</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần
                        </option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bán chạy
                        </option>
                    </select>
                </div>

                {{-- Nút làm mới --}}
                <div class="col-auto ms-auto">
                    <a href="{{ url()->current() }}" class="btn btn-outline-primary px-3">
                        <i class="bi bi-arrow-repeat me-1"></i> Làm mới
                    </a>
                </div>
            </form>
        </div>
    </section>

    {{-- 🌟 SẢN PHẨM NỔI BẬT --}}
    <section class="py-5 featured-section">
        <div class="container">
            <h2 class="section-title"><i class="bi bi-stars"></i> SẢN PHẨM NỔI BẬT</h2>
            <div class="row g-4">
                @foreach ($listpro ?? [] as $item)
                    <div class="col-6 col-md-4 col-xl-3">
                        <a href="{{ route('client.products.detail', $item->id) }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 product-card">
                                <div class="rounded-top-4 overflow-hidden position-relative">
                                    @if ($item->sale ?? 0 > 0)
                                        <span
                                            class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                                            -{{ $item->sale }}%
                                        </span>
                                    @endif
                                    <img src="{{ asset('storage/products/' . ($item->fileName ?? 'no-image.png')) }}"
                                        alt="{{ $item->proname ?? $item->name }}" class="card-img-top hover-scale"
                                        style="height:230px; object-fit:cover;">
                                </div>
                                <div class="card-body text-center">
                                    <h6 class="fw-semibold mb-2 product-title">{{ $item->proname ?? $item->name }}</h6>
                                    <p class="text-danger fw-bold mb-1">{{ number_format($item->price ?? 0) }}đ</p>

                                    {{-- ⭐ Đánh giá --}}
                                    @php $avg = round($item->reviews()->avg('rating')); @endphp
                                    <div class="star-rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $avg ? 'text-warning' : 'text-muted' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 🛒 DANH SÁCH SẢN PHẨM --}}
    <section class="py-4">
        <div class="container">
            <h3 class="mb-4 fw-bold section-subtitle">Tất cả sản phẩm</h3>
            <div class="row g-3">
                @forelse ($products ?? [] as $item)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('client.products.detail', $item->id) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm rounded-3 product-card">
                                <div class="position-relative overflow-hidden rounded-top-3">
                                    @if ($item->sale ?? 0 > 0)
                                        <span
                                            class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                                            -{{ $item->sale }}%
                                        </span>
                                    @endif
                                    <img src="{{ asset('storage/products/' . ($item->fileName ?? 'no-image.png')) }}"
                                        alt="{{ $item->proname ?? $item->name }}" class="card-img-top hover-scale"
                                        style="height:200px; object-fit:cover;">
                                </div>
                                <div class="card-body text-center">
                                    <h6 class="fw-semibold mb-2 product-title">{{ $item->proname ?? $item->name }}</h6>
                                    <p class="text-danger fw-bold mb-1">{{ number_format($item->price ?? 0) }}đ</p>

                                    {{-- ⭐ Đánh giá --}}
                                    @php $avg = round($item->reviews()->avg('rating')); @endphp
                                    <div class="star-rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $avg ? 'text-warning' : 'text-muted' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center text-muted">Không có sản phẩm nào phù hợp với lựa chọn hiện tại.</p>
                @endforelse
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-center mt-4">
                @if (isset($products) && method_exists($products, 'withQueryString'))
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </section>

    {{-- 🎨 CSS TÙY CHỈNH --}}
    <style>
        /* ===================== BỘ LỌC ===================== */
        .filter-bar {
            background: var(--bg-light);
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        [data-theme="dark"] .filter-bar {
            background: #1e293b;
            box-shadow: 0 2px 6px rgba(255, 255, 255, 0.05);
        }

        .filter-bar .form-select,
        .filter-bar .btn {
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: 0.2s;
        }

        [data-theme="dark"] .filter-bar .form-select {
            background: #0f172a;
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.1);
        }

        [data-theme="dark"] .filter-bar .form-select option {
            background: #0f172a;
            color: #e2e8f0;
        }

        .filter-bar .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        [data-theme="dark"] .filter-bar .btn-outline-primary {
            color: #60a5fa;
            border-color: #60a5fa;
        }

        .filter-bar .btn-outline-primary:hover {
            background: var(--primary-color);
            color: #fff;
        }

        [data-theme="dark"] .filter-bar .btn-outline-primary:hover {
            background: #60a5fa;
            color: #fff;
        }

        /* ===================== SẢN PHẨM ===================== */
        .hover-scale {
            transition: transform 0.4s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .product-card {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            border-radius: 12px;
        }

        .product-card:hover {
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
        }

        [data-theme="dark"] .product-card {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-theme="dark"] .product-title {
            color: #e2e8f0;
        }

        .star-rating span {
            font-size: 1rem;
            margin-right: 2px;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        [data-theme="dark"] .text-muted {
            color: #475569 !important;
        }

        /* ===================== 🎯 PHÂN TRANG ===================== */
        /* ===================== 🎯 PHÂN TRANG NÂNG CẤP ===================== */
        .pagination {
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 2rem;
            font-weight: 500;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-item .page-link {
            border: none;
            border-radius: 10px;
            background: #f8fafc;
            color: #1e293b;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 8px 14px;
            transition: all 0.25s ease-in-out;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Hover & focus */
        .pagination .page-item .page-link:hover,
        .pagination .page-item .page-link:focus {
            background: #2563eb;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        }

        /* Active */
        .pagination .page-item.active .page-link {
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        }

        /* Disabled */
        .pagination .page-item.disabled .page-link {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }

        /* Ẩn dòng thông báo kết quả */
        .pagination~p {
            display: none !important;
        }

        /* DARK MODE */
        [data-theme="dark"] .pagination .page-item .page-link {
            background: #1e293b;
            color: #e2e8f0;
            box-shadow: 0 1px 2px rgba(255, 255, 255, 0.05);
        }

        [data-theme="dark"] .pagination .page-item .page-link:hover {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 3px 8px rgba(59, 130, 246, 0.25);
        }

        [data-theme="dark"] .pagination .page-item.active .page-link {
            background: #3b82f6;
            color: #fff;
            font-weight: 600;
        }

        [data-theme="dark"] .pagination .page-item.disabled .page-link {
            background: #334155;
            color: #64748b;
        }

        /* Bo góc mượt và spacing hài hòa */
        .pagination .page-link {
            min-width: 38px;
            text-align: center;
        }

        .pagination~p {
            display: none !important;
        }
    </style>

    {{-- ⚡ AJAX PHÂN TRANG (không reload trang) --}}
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Xử lý khi bấm phân trang (AJAX)
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    // Render lại vùng danh sách sản phẩm
                    let html = $(response).find('#product-list').html();
                    $('#product-list').html(html);
                    window.scrollTo({
                        top: 300,
                        behavior: 'smooth'
                    });
                },
                error: function() {
                    alert('Không thể tải dữ liệu, vui lòng thử lại.');
                }
            });
        });
    </script>
@endsection
