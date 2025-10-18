@extends('layout.client')

@section('content')
    @php
        $cart = Session::get('cart', []);
        $total = 0;
    @endphp

    <section class="py-5">
        <div class="container">
            <h3 class="mb-4 text-primary fw-bold">🧾 Thông tin đặt hàng</h3>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-5">
                {{-- Form Thông tin người mua + phương thức thanh toán --}}
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm rounded-4">
                        <h5 class="mb-3">📋 Điền thông tin giao hàng</h5>

                        {{-- Hiển thị lỗi validation --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- ✅ SỬA: Action đúng route và method POST --}}
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf

                            {{-- ✅ SỬA: name="name" thay vì "fullname" --}}
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    required>
                            </div>

                            {{-- ✅ SỬA: name="phone" thay vì "tel" --}}
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                    required>
                            </div>

                            {{-- ✅ SỬA: name="note" thay vì "description" --}}
                            <div class="mb-3">
                                <label class="form-label">Ghi chú đơn hàng</label>
                                <textarea class="form-control" name="note" rows="2">{{ old('note') }}</textarea>
                            </div>

                            <h6 class="fw-bold mb-3">💳 Phương thức thanh toán</h6>

                            <div class="form-check mb-2 p-3 border rounded">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                    value="cod" checked>
                                <label class="form-check-label w-100" for="cod">
                                    <strong>💵 Thanh toán khi nhận hàng (COD)</strong>
                                    <div class="text-muted small">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                </label>
                            </div>

                            <div class="form-check mb-4 p-3 border rounded">
                                <input class="form-check-input" type="radio" name="payment_method" id="momo"
                                    value="momo">
                                <label class="form-check-label w-100" for="momo">
                                    <strong>🎀 Ví MoMo</strong>
                                    <div class="text-muted small">Quét mã QR để thanh toán</div>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px;">
                                🚀 Xác nhận đặt hàng
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Thông tin đơn hàng --}}
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm rounded-4">
                        <h5 class="mb-3">📦 Chi tiết đơn hàng</h5>
                        <table class="table align-middle">
    <thead>
        <tr>
            <th>STT</th>
            <th>Sản phẩm</th>
            <th>SL</th>
            <th>Giá</th>
            <th>T.Tiền</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($cart as $item)
            @php
                $price = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $productName = $item['proname'] ?? ($item['name'] ?? 'Sản phẩm');
                $color = $item['color'] ?? null;
                $version = $item['version'] ?? null;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $productName }}
                    @if ($color || $version)
                        <div class="small text-muted">
                            @if ($color)
                                Màu: <strong>{{ $color }}</strong>
                            @endif
                            @if ($version)
                                • Phiên bản: <strong>{{ $version }}</strong>
                            @endif
                        </div>
                    @endif
                </td>
                <td>{{ $quantity }}</td>
                <td>{{ number_format($price) }}đ</td>
                <td class="text-danger">{{ number_format($subtotal) }}đ</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống</td>
            </tr>
        @endforelse

        @if (!empty($cart))
            <tr class="fw-bold">
                <td colspan="4" class="text-end">Tổng tiền:</td>
                <td class="text-danger">{{ number_format($total) }}đ</td>
            </tr>
        @endif
    </tbody>
</table>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ✅ XÓA HOÀN TOÀN script JavaScript không cần thiết --}}
    {{-- Controller sẽ tự động xử lý redirect dựa vào payment_method --}}

@endsection
