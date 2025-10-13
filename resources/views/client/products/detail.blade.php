@extends('layout.client')

@section('content')
    <section class="py-4 bg-light">
        <div class="container bg-white p-4 rounded shadow-sm">

            {{-- Thông báo --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                {{-- Cột trái: gallery hình --}}
                <div class="col-md-5">
                    <div class="border rounded overflow-hidden position-relative">
                        <img src="{{ asset('storage/products/' . ($product->fileName ?? 'no-image.png')) }}"
                             id="mainProductImg" class="w-100" style="object-fit:contain; max-height:450px;"
                             alt="{{ $product->proname }}">
                    </div>

                    {{-- Thumbnails --}}
                    @if (!empty($product->gallery))
                        <div class="d-flex gap-2 flex-wrap mt-3">
                            @foreach ($product->gallery as $img)
                                <img src="{{ asset('storage/products/' . $img) }}"
                                     class="img-thumbnail product-thumb"
                                     style="width:70px; height:70px; object-fit:cover; cursor:pointer;">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Cột phải: thông tin sản phẩm --}}
                <div class="col-md-7">
                    <h3 class="fw-bold mb-2">{{ $product->proname }}</h3>

                    {{-- Đánh giá trung bình --}}
                    <div class="d-flex align-items-center mb-3 text-muted small">
                        @php
                            $avg = round($product->reviews->avg('rating'), 1);
                        @endphp
                        <span class="me-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $avg ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <span class="ms-1">{{ $avg }}/5</span>
                        </span>
                        <span class="mx-2">|</span>
                        <span>Đã bán: 1.2k+</span>
                    </div>

                    {{-- Giá --}}
                    <div class="bg-light p-3 rounded mb-3">
                        @if ($product->sale > 0)
                            <span class="text-danger fs-3 fw-bold me-2">
                                {{ number_format(($product->price * (100 - $product->sale)) / 100) }}đ
                            </span>
                            <span class="text-muted text-decoration-line-through">
                                {{ number_format($product->price) }}đ
                            </span>
                            <span class="badge bg-danger ms-2">-{{ $product->sale }}%</span>
                        @else
                            <span class="text-danger fs-3 fw-bold">{{ number_format($product->price) }}đ</span>
                        @endif
                    </div>

                    <p class="mb-4">{{ $product->description }}</p>

                    {{-- Form giỏ hàng / mua ngay --}}
                    <form action="{{ route('cartadd', $product->id) }}" method="POST" class="d-flex gap-3 mb-3">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-lg px-4">
                            <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ hàng
                        </button>
                        <button type="submit" name="redirect" value="checkout" class="btn btn-danger btn-lg px-4">
                            🛒 Mua Ngay
                        </button>
                    </form>

                    <div class="border rounded p-3 small text-muted">
                        <p class="mb-1"><i class="bi bi-truck me-2"></i>Giao hàng tiêu chuẩn: 2-5 ngày</p>
                        <p class="mb-0"><i class="bi bi-shield-check me-2"></i>Đổi trả miễn phí trong 15 ngày</p>
                    </div>

                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">← Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form đánh giá --}}
    <h5 class="mt-5">Đánh giá sản phẩm</h5>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.reviews.store', $product->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Chọn số sao:</label>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                    <label for="star{{ $i }}" title="{{ $i }} sao">★</label>
                @endfor
            </div>
            @error('rating')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <textarea name="comment" class="form-control" rows="3" placeholder="Viết nhận xét của bạn..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
    </form>

    <hr>

    {{-- Hiển thị danh sách đánh giá --}}
    <h5>⭐ Đánh giá từ khách hàng</h5>
    @foreach ($product->reviews as $review)
        <div class="border rounded p-2 mb-2">
            <div>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}">★</span>
                @endfor
            </div>
            <p class="mb-0">{{ $review->comment }}</p>
            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
        </div>
    @endforeach

    {{-- CSS --}}
    <style>
        /* Chọn số sao trong form */
        .star-rating {
            display: inline-flex;
            flex-direction: row-reverse;
            font-size: 2rem;
            cursor: pointer;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            padding: 0 4px;
            transition: color 0.2s;
        }

        /* Khi hover hoặc chọn sao */
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
        }

        /* Thumbnail ảnh */
        .product-thumb {
            border: 2px solid transparent;
            transition: border 0.2s ease, transform 0.2s ease;
        }

        .product-thumb:hover {
            border-color: #ff6f00;
            transform: scale(1.05);
        }
    </style>

    {{-- JS đổi ảnh chính --}}
    <script>
        document.querySelectorAll('.product-thumb').forEach(img => {
            img.addEventListener('click', () => {
                document.getElementById('mainProductImg').src = img.src;
            });
        });
    </script>
@endsection
