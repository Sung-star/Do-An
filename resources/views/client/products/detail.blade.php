@extends('layout.client')

@section('content')
    <section class="py-4">
        <div class="container">

            {{-- 🧭 Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.products.search') }}">Sản phẩm</a></li>
                    @if ($product->category ?? false)
                        <li class="breadcrumb-item">
                            <a href="{{ route('client.products.search', ['category' => $product->category->id]) }}">
                                {{ $product->category->catename }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->proname }}</li>
                </ol>
            </nav>

            {{-- 🏷️ Khung chi tiết --}}
            <div class="bg-white rounded-4 shadow-lg p-4" data-aos="fade-up">
                <div class="row g-4 align-items-start">

                    {{-- 🖼️ GALLERY --}}
                    <div class="col-lg-6">
                        @php
                            $mainImg = asset('storage/products/' . ($product->fileName ?? 'no-image.png'));
                            $thumbs = collect($product->gallery ?? [])
                                ->prepend($product->fileName)
                                ->filter()
                                ->unique()
                                ->values();
                        @endphp

                        <div class="gallery-wrapper">
                            <div class="main-img-container border rounded-4 position-relative overflow-hidden">
                                <img id="mainProductImg" src="{{ $mainImg }}" class="img-fluid main-img"
                                    alt="{{ $product->proname }}">
                                <div class="zoom-hint">🖱️ Di chuột để phóng to</div>
                            </div>

                            @if ($thumbs->count())
                                <div class="thumb-list d-flex flex-wrap gap-2 mt-3">
                                    @foreach ($thumbs as $img)
                                        <img src="{{ asset('storage/products/' . $img) }}"
                                            class="thumb-item rounded-3 border" alt="thumb">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- 🧾 THÔNG TIN SẢN PHẨM --}}
                    <div class="col-lg-6">
                        <h1 class="h4 fw-bold mb-2 text-gradient">{{ $product->proname }}</h1>

                        <div class="d-flex flex-wrap align-items-center gap-2 text-muted small mb-2">
                            <span>Mã SP: <span
                                    class="fw-semibold text-dark">{{ $product->sku ?? 'HS' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</span></span>
                            @if ($product->brand ?? false)
                                <span class="vr mx-2"></span>
                                <span>Thương hiệu:
                                    <a href="{{ route('client.products.search', ['brand' => $product->brand->id]) }}"
                                        class="link-primary fw-semibold">{{ $product->brand->brandname }}</a>
                                </span>
                            @endif
                            <span class="vr mx-2"></span>
                            <span class="badge bg-success-subtle text-success border border-success">Còn hàng</span>
                        </div>

                        {{-- ⭐ ĐÁNH GIÁ --}}
                        @php $avg = round($product->reviews->avg('rating'), 1); @endphp
                        <div class="d-flex align-items-center mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $avg ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <span class="ms-2 small text-muted">{{ $avg }}/5 ({{ $product->reviews->count() }}
                                đánh giá)</span>
                        </div>

                        {{-- 🎨 Chọn màu sắc --}}
                        <div class="mb-3">
                            <h6 class="fw-semibold mb-2">Màu sắc:</h6>
                            <div class="d-flex flex-wrap gap-2" id="colorOptions">
                                <button type="button" class="btn btn-outline-secondary btn-sm color-opt active"
                                    data-color="Đen">Đen</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm color-opt"
                                    data-color="Bạc">Bạc</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm color-opt"
                                    data-color="Xanh">Xanh</button>
                            </div>
                            <input type="hidden" name="color" id="selectedColor" value="Đen">
                            <small class="text-muted">Đang chọn: <span id="colorLabel">Đen</span></small>
                        </div>

                        {{-- ⚙️ Chọn phiên bản (ẩn nếu không có) --}}
                        @if ($product->has_version)
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-2">Phiên bản:</h6>
                                <div class="d-flex flex-wrap gap-2" id="versionOptions">
                                    <button type="button" class="btn btn-outline-secondary btn-sm version-opt active"
                                        data-version="128GB">128GB</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm version-opt"
                                        data-version="256GB">256GB</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm version-opt"
                                        data-version="512GB">512GB</button>
                                </div>
                                <input type="hidden" name="version" id="selectedVersion" value="128GB">
                            </div>
                        @endif
                        {{-- 💰 GIÁ --}}
                        <div class="bg-light border rounded-3 p-3 mb-3">
                            @if ($product->sale > 0)
                                <div class="d-flex align-items-baseline gap-2">
                                    <span class="text-danger fs-3 fw-bold price-display">
                                        {{ number_format(($product->price * (100 - $product->sale)) / 100) }}đ
                                    </span>
                                    <span class="text-muted text-decoration-line-through">
                                        {{ number_format($product->price) }}đ
                                    </span>
                                    <span class="badge bg-danger ms-1">-{{ $product->sale }}%</span>
                                </div>
                            @else
                                <span class="text-danger fs-3 fw-bold price-display">
                                    {{ number_format($product->price) }}đ
                                </span>
                            @endif
                        </div>

                        {{-- 🛒 FORM GIỎ HÀNG --}}
                        <form id="addToCartForm" action="{{ route('cartadd', $product->id) }}" method="POST"
                            class="mb-3">
                            @csrf

                            {{-- 🧩 Input ẩn để lưu màu sắc & phiên bản (quan trọng!) --}}
                            <input type="hidden" name="color" id="selectedColor" value="Đen">
                            <input type="hidden" name="version" id="selectedVersion" value="128GB">

                            <div class="d-flex flex-wrap align-items-center gap-3">
                                {{-- 🔢 Chọn số lượng --}}
                                <div class="input-group qty-group" style="width: 160px;">
                                    <button class="btn btn-outline-secondary" type="button" id="btnMinus"><i
                                            class="bi bi-dash-lg"></i></button>
                                    <input type="number" name="qty" id="qtyInput" class="form-control text-center"
                                        value="1" min="1" max="{{ max(1, $product->stock ?? 1) }}">
                                    <button class="btn btn-outline-secondary" type="button" id="btnPlus"><i
                                            class="bi bi-plus-lg"></i></button>
                                </div>

                                {{-- 🛍️ Nút hành động --}}
                                <button type="submit" class="btn btn-warning px-4 text-dark fw-semibold">
                                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                                </button>
                                <button type="submit" name="redirect" value="checkout" class="btn btn-danger px-4">
                                    <i class="bi bi-lightning-charge me-1"></i> Mua ngay
                                </button>
                            </div>
                        </form>


                        {{-- 🔘 HÀNH ĐỘNG PHỤ --}}
                        <div class="d-flex flex-wrap gap-3 mb-3 small">
                            <button class="btn btn-outline-primary btn-sm" id="btnWishlist">
                                <i class="bi bi-heart me-1"></i> Yêu thích
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" id="btnCompare">
                                <i class="bi bi-bar-chart me-1"></i> So sánh
                            </button>
                            <button class="btn btn-outline-success btn-sm" id="btnShare">
                                <i class="bi bi-share me-1"></i> Chia sẻ
                            </button>
                            <button class="btn btn-outline-dark btn-sm" id="btnCopy">
                                <i class="bi bi-link-45deg me-1"></i> Sao chép link
                            </button>
                        </div>

                        {{-- 🚚 ƯỚC TÍNH PHÍ SHIP --}}
                        <div class="border rounded-3 p-3 bg-light small text-muted mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-7 col-sm-8">
                                    <label class="form-label mb-1">Ước tính phí vận chuyển</label>
                                    <input id="shipZip" type="text" class="form-control form-control-sm"
                                        placeholder="Nhập quận/huyện hoặc mã bưu chính">
                                </div>
                                <div class="col-5 col-sm-4 d-grid">
                                    <button class="btn btn-sm btn-outline-primary" id="btnCalcShip">Tính phí</button>
                                </div>
                            </div>
                            <div id="shipResult" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🎨 CSS DARK MODE & STYLE --}}
    <style>
        .thumb-item {
            width: 70px;
            height: 70px;
            object-fit: cover;
            cursor: pointer;
            transition: .3s;
        }

        .thumb-item.active {
            border: 2px solid #3b82f6;
        }

        .main-img {
            max-height: 420px;
            transition: transform .25s;
        }

        .main-img:hover {
            transform: scale(1.05);
        }

        .zoom-hint {
            position: absolute;
            bottom: 8px;
            right: 10px;
            font-size: 12px;
            color: #888;
        }

        [data-theme="dark"] .bg-white,[data-theme="dark"] .rounded-4 {
            background: #1e293b !important;
            color: #f1f5f9 !important;
        }

        [data-theme="dark"] h1.text-gradient {
            background: linear-gradient(90deg, #fff, #a3bffa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="dark"] .price-display {
            color: #f87171 !important;
        }

        [data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-theme="dark"] .btn-warning {
            background-color: #60a5fa;
            color: #fff;
        }

        [data-theme="dark"] .btn-danger {
            background-color: #ef4444;
            color: #fff;
        }

        [data-theme="dark"] .btn-outline-primary {
            color: #60a5fa;
            border-color: #60a5fa;
        }

        [data-theme="dark"] .btn-outline-secondary {
            color: #94a3b8;
            border-color: #64748b;
        }

        [data-theme="dark"] .btn-outline-dark {
            color: #e2e8f0;
            border-color: #475569;
        }

        .color-opt.active,
        .version-opt.active {
            border-color: #3b82f6;
            background: #3b82f6;
            color: #fff;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btnWishlist = document.getElementById("btnWishlist");
                const btnCompare = document.getElementById("btnCompare");
                const btnShare = document.getElementById("btnShare");
                const btnCopy = document.getElementById("btnCopy");

                // 🧡 1. YÊU THÍCH — lưu localStorage
                btnWishlist.addEventListener("click", () => {
                    const productId = "{{ $product->id ?? 0 }}";
                    let favorites = JSON.parse(localStorage.getItem("wishlist")) || [];
                    const exists = favorites.includes(productId);

                    if (exists) {
                        favorites = favorites.filter(id => id !== productId);
                        localStorage.setItem("wishlist", JSON.stringify(favorites));
                        Swal.fire({
                            icon: "info",
                            title: "Đã xóa khỏi danh sách yêu thích!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        btnWishlist.classList.remove("btn-primary");
                        btnWishlist.classList.add("btn-outline-primary");
                    } else {
                        favorites.push(productId);
                        localStorage.setItem("wishlist", JSON.stringify(favorites));
                        Swal.fire({
                            icon: "success",
                            title: "Đã thêm vào danh sách yêu thích!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        btnWishlist.classList.remove("btn-outline-primary");
                        btnWishlist.classList.add("btn-primary");
                    }
                });

                // 📊 2. SO SÁNH — lưu tối đa 3 sản phẩm
                btnCompare.addEventListener("click", () => {
                    const product = {
                        id: "{{ $product->id ?? 0 }}",
                        name: "{{ $product->proname ?? '' }}",
                        price: "{{ number_format($product->price, 0, ',', '.') }}₫"
                    };
                    let compareList = JSON.parse(localStorage.getItem("compareList")) || [];

                    if (compareList.some(p => p.id === product.id)) {
                        Swal.fire({
                            icon: "info",
                            title: "Sản phẩm đã có trong danh sách so sánh",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    if (compareList.length >= 3) {
                        Swal.fire({
                            icon: "warning",
                            title: "Chỉ có thể so sánh tối đa 3 sản phẩm!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    compareList.push(product);
                    localStorage.setItem("compareList", JSON.stringify(compareList));
                    Swal.fire({
                        icon: "success",
                        title: "Đã thêm vào danh sách so sánh!",
                        toast: true,
                        position: "top-end",
                        timer: 2000,
                        showConfirmButton: false
                    });
                });

                // 🔗 3. CHIA SẺ — mở giao diện native (nếu hỗ trợ)
                btnShare.addEventListener("click", async () => {
                    const shareData = {
                        title: "{{ $product->proname ?? 'Sản phẩm HS Store' }}",
                        text: "Hãy xem sản phẩm này tại HS Store!",
                        url: window.location.href
                    };

                    if (navigator.share) {
                        await navigator.share(shareData).catch(() => {});
                    } else {
                        navigator.clipboard.writeText(window.location.href);
                        Swal.fire({
                            icon: "info",
                            title: "Đã sao chép link chia sẻ!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });

                // 🧭 4. SAO CHÉP LINK
                btnCopy.addEventListener("click", () => {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        Swal.fire({
                            icon: "success",
                            title: "Đã sao chép liên kết sản phẩm!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }).catch(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Không thể sao chép link!",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const qtyInput = document.getElementById('qtyInput'),
                    btnMinus = document.getElementById('btnMinus'),
                    btnPlus = document.getElementById('btnPlus'),
                    priceElement = document.querySelector('.price-display'),
                    mainImg = document.getElementById('mainProductImg'),
                    thumbs = document.querySelectorAll('.thumb-item');
                const basePrice = Number(@json((int) ($product->sale > 0 ? ($product->price * (100 - $product->sale)) / 100 : $product->price)));

                function updatePrice() {
                    const qty = Math.max(1, Number(qtyInput.value) || 1);
                    qtyInput.value = qty;
                    priceElement.textContent = (basePrice * qty).toLocaleString('vi-VN') + 'đ';
                }
                btnMinus?.addEventListener('click', () => {
                    qtyInput.value = Math.max(1, Number(qtyInput.value) - 1);
                    updatePrice();
                });
                btnPlus?.addEventListener('click', () => {
                    qtyInput.value = Number(qtyInput.value) + 1;
                    updatePrice();
                });
                qtyInput?.addEventListener('input', updatePrice);
                updatePrice();

                thumbs.forEach(t => {
                    t.addEventListener('click', () => {
                        thumbs.forEach(x => x.classList.remove('active'));
                        t.classList.add('active');
                        mainImg.src = t.src;
                    });
                });

                // ==== chọn màu ====
                const colorBtns = document.querySelectorAll('.color-opt'),
                    colorHidden = document.getElementById('selectedColor'),
                    colorLabel = document.getElementById('colorLabel');
                colorBtns.forEach(btn => btn.addEventListener('click', () => {
                    colorBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    colorHidden.value = btn.dataset.color;
                    colorLabel.textContent = btn.dataset.color;
                }));

                // ==== chọn phiên bản ====
                const versionBtns = document.querySelectorAll('.version-opt'),
                    versionHidden = document.getElementById('selectedVersion');
                versionBtns.forEach(btn => btn.addEventListener('click', () => {
                    versionBtns.forEach(v => v.classList.remove('active'));
                    btn.classList.add('active');
                    versionHidden.value = btn.dataset.version;
                }));

                // ==== Copy link & share ====
                const copyBtn = document.getElementById('btnCopy'),
                    shareBtn = document.getElementById('btnShare');
                const toastHost = document.createElement('div');
                toastHost.style.cssText =
                    'position:fixed;top:16px;right:16px;z-index:1080;display:flex;flex-direction:column;gap:8px;';
                document.body.appendChild(toastHost);

                function showToast(msg, type = 'dark') {
                    const item = document.createElement('div');
                    item.className = 'px-3 py-2 text-white rounded-3 shadow';
                    item.style.background = type === 'success' ? '#16a34a' : type === 'danger' ? '#dc2626' : type ===
                        'warning' ? '#f59e0b' : '#111827';
                    item.textContent = msg;
                    toastHost.appendChild(item);
                    setTimeout(() => item.remove(), 2000);
                }
                copyBtn?.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(location.href);
                        showToast('🔗 Đã sao chép liên kết', 'success');
                    } catch {
                        showToast('Không thể sao chép', 'danger');
                    }
                });
                shareBtn?.addEventListener('click', async () => {
                    if (navigator.share) {
                        await navigator.share({
                            title: document.title,
                            url: location.href
                        });
                    } else showToast('Thiết bị không hỗ trợ', 'warning');
                });

                // ==== Recent viewed ====
                const currentId = Number(@json($product->id)),
                    key = 'recentProducts';
                const item = {
                    id: currentId,
                    name: @json($product->proname),
                    img: mainImg?.src || '',
                    price: basePrice,
                    url: @json(route('client.products.detail', $product->id))
                };
                let list = [];
                try {
                    list = JSON.parse(localStorage.getItem(key) || '[]');
                } catch {}
                list = [item, ...list.filter(x => x.id !== currentId)].slice(0, 8);
                localStorage.setItem(key, JSON.stringify(list));
                const container = document.querySelector('section .container');
                if (container) {
                    let wrap = document.getElementById('recentWrapper');
                    if (!wrap) {
                        wrap = document.createElement('div');
                        wrap.id = 'recentWrapper';
                        wrap.className = 'mt-5';
                        wrap.innerHTML =
                            '<h5 class="fw-bold mb-3 text-gradient">Bạn đã xem</h5><div id="recentGrid" class="row g-3"></div>';
                        container.appendChild(wrap);
                    }
                    const grid = wrap.querySelector('#recentGrid');
                    grid.innerHTML = list.map(p =>
                        `<div class="col-6 col-md-3"><a href="${p.url}" class="text-decoration-none"><div class="card h-100 border-0 shadow-sm rounded-3 hover-scale"><img src="${p.img}" class="card-img-top" style="height:200px;object-fit:cover"><div class="card-body text-center"><h6 class="text-dark mb-1 text-truncate">${p.name}</h6><div class="text-danger fw-semibold">${(p.price||0).toLocaleString('vi-VN')}đ</div></div></div></a></div>`
                    ).join('');
                }
            });
        </script>
    @endpush
@endsection
