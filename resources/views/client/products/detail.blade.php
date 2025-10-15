@extends('layout.client')

@section('content')
<section class="py-5 bg-light">
    <div class="container bg-white p-4 rounded-4 shadow-sm" data-aos="fade-up" data-aos-duration="900">

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="zoom-in">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Cột trái: hình ảnh sản phẩm --}}
            <div class="col-md-6" data-aos="zoom-in-right" data-aos-delay="100">
                <div class="border rounded-4 overflow-hidden shadow-sm bg-white position-relative">
                    <img src="{{ asset('storage/products/' . ($product->fileName ?? 'no-image.png')) }}"
                        id="mainProductImg"
                        class="w-100"
                        style="object-fit: contain; max-height: 460px;"
                        alt="{{ $product->proname }}">
                </div>

                {{-- Thumbnails --}}
                @if (!empty($product->gallery))
                    <div class="d-flex flex-wrap gap-2 mt-3" data-aos="fade-up" data-aos-delay="150">
                        @foreach ($product->gallery as $img)
                            <img src="{{ asset('storage/products/' . $img) }}"
                                class="img-thumbnail product-thumb"
                                style="width: 75px; height: 75px; object-fit: cover; border-radius: 8px; cursor: pointer;">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Cột phải: thông tin chi tiết --}}
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                <h3 class="fw-bold text-dark mb-2">{{ $product->proname }}</h3>

                {{-- Đánh giá --}}
                @php $avg = round($product->reviews->avg('rating'), 1); @endphp
                <div class="d-flex align-items-center text-muted mb-3">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star-fill {{ $i <= $avg ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                    <span class="ms-2 small">{{ $avg }}/5 ({{ $product->reviews->count() }} đánh giá)</span>
                </div>

                {{-- Giá --}}
                <div class="bg-light border rounded-3 p-3 mb-4 shadow-sm" data-aos="zoom-in" data-aos-delay="250">
                    @if ($product->sale > 0)
                        <span class="text-danger fs-3 fw-bold me-2">
                            {{ number_format(($product->price * (100 - $product->sale)) / 100) }}đ
                        </span>
                        <span class="text-muted text-decoration-line-through">
                            {{ number_format($product->price) }}đ
                        </span>
                        <span class="badge bg-danger ms-2 px-2 py-1">-{{ $product->sale }}%</span>
                    @else
                        <span class="text-danger fs-3 fw-bold">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>

                {{-- Mô tả --}}
                <p class="text-secondary" style="line-height: 1.6;" data-aos="fade-up" data-aos-delay="300">
                    {{ $product->description }}
                </p>

                {{-- Form giỏ hàng --}}
                <form action="{{ route('cartadd', $product->id) }}" method="POST" class="d-flex flex-wrap gap-3 mb-4">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-lg px-4 text-dark fw-semibold" data-aos="fade-up" data-aos-delay="350">
                        <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                    </button>
                    <button type="submit" name="redirect" value="checkout" class="btn btn-danger btn-lg px-4" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-lightning-charge me-1"></i> Mua ngay
                    </button>
                </form>

                <div class="border rounded-3 p-3 bg-light small text-muted" data-aos="fade-up" data-aos-delay="450">
                    <p class="mb-1"><i class="bi bi-truck me-2 text-primary"></i> Giao hàng tiêu chuẩn: 2-5 ngày</p>
                    <p class="mb-0"><i class="bi bi-shield-check me-2 text-success"></i> Đổi trả miễn phí trong 15 ngày</p>
                </div>

                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm mt-3" data-aos="fade-up" data-aos-delay="500">
                    ← Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Form đánh giá --}}
<section class="container my-5" data-aos="fade-up" data-aos-duration="800">
    <div class="p-4 bg-white rounded-4 shadow-sm">
        <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-chat-dots me-2"></i>Đánh giá sản phẩm</h5>

        <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="mb-4" data-aos="fade-up" data-aos-delay="100">
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

            <div class="mb-3" data-aos="fade-up" data-aos-delay="150">
                <textarea name="comment" class="form-control rounded-3" rows="3" placeholder="Viết nhận xét của bạn..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4" data-aos="zoom-in">Gửi đánh giá</button>
        </form>

        {{-- Danh sách đánh giá --}}
        <h6 class="fw-bold mb-3">⭐ Đánh giá từ khách hàng</h6>
        @forelse ($product->reviews as $review)
            <div class="border rounded-3 p-3 mb-2" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}">★</span>
                    @endfor
                </div>
                <p class="mb-1">{{ $review->comment }}</p>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
        @endforelse
    </div>
</section>

{{-- CSS --}}
<style>
    .product-thumb {
        border: 2px solid transparent;
        transition: all 0.25s ease;
    }
    .product-thumb:hover {
        border-color: #004aad;
        transform: scale(1.07);
    }

    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        font-size: 1.8rem;
        cursor: pointer;
    }
    .star-rating input[type="radio"] { display: none; }
    .star-rating label {
        color: #ccc;
        padding: 0 3px;
        transition: color 0.25s;
    }
    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }
</style>

{{-- JS --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    // Khởi tạo AOS
    AOS.init({ once: true });

    // Đổi ảnh chính khi click thumbnail
    document.querySelectorAll('.product-thumb').forEach(img => {
        img.addEventListener('click', () => {
            document.getElementById('mainProductImg').src = img.src;
        });
    });
</script>
@endsection
