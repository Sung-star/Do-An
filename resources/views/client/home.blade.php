@extends('layout.client')

@section('content')
    {{-- Bộ lọc --}}
    <section class="py-3 bg-white">
        <div class="container">
            <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center">
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
                        <option value="">-- Lọc theo giá --</option>
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
                        <option value="">-- Sắp xếp --</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần
                        </option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bán chạy
                        </option>
                    </select>
                </div>

                <div class="col-auto">
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </section>

    {{-- Sản phẩm nổi bật --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-5 text-center fw-bold text-uppercase text-dark">✨ Sản phẩm nổi bật</h2>
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
                                    <h6 class="fw-semibold text-dark mb-2">{{ $item->proname ?? $item->name }}</h6>
                                    <p class="text-danger fw-bold mb-1">{{ number_format($item->price ?? 0) }}đ</p>

                                    {{-- ⭐ Rating --}}
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

    {{-- Danh sách sản phẩm --}}
    <section class="py-4">
        <div class="container">
            <h3 class="mb-4">Tất cả sản phẩm</h3>
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
                                    <h6 class="fw-semibold text-dark mb-2">{{ $item->proname ?? $item->name }}</h6>
                                    <p class="text-danger fw-bold mb-1">{{ number_format($item->price ?? 0) }}đ</p>

                                    {{-- ⭐ Rating (đã thêm) --}}
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
                    <p class="text-center text-muted">Không có sản phẩm nào phù hợp.</p>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                @if (isset($products) && method_exists($products, 'withQueryString'))
                    {{ $products->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </section>

    {{-- CSS --}}
    <style>
        /* Hiệu ứng phóng to ảnh */
        .hover-scale {
            transition: transform 0.4s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Card sản phẩm */
        .product-card {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            border-radius: 12px;
        }

        .product-card:hover {
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
        }

        /* Tiêu đề sản phẩm */
        .card-body h6 {
            min-height: 42px;
            font-size: 0.95rem;
        }

        /* ⭐ Đánh giá sao */
        .star-rating {
            font-size: 0.9rem;
        }

        .star-rating span {
            margin-right: 2px;
            font-size: 1rem;
        }

        .star-rating .text-warning {
            color: #ffc107 !important;
            /* Vàng tươi */
        }

        .star-rating .text-muted {
            color: #d1d1d1 !important;
            /* Xám nhạt */
        }
    </style>
@endsection
