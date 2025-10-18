@extends('layout.client')

@section('content')
    {{-- 🌈 Header Success --}}
    <div class="py-5" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 200px;">
        <div class="container text-center text-white">
            <h1 class="display-4 fw-bold mb-2">✅ Đặt hàng thành công!</h1>
            <p class="lead">Cảm ơn bạn đã mua sắm tại HS Store 💚</p>
        </div>
    </div>

    {{-- 🧾 Nội dung --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- 🎉 Thông báo thành công --}}
                <div class="text-center mb-5">
                    <div class="mb-4">
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-3">Đơn hàng của bạn đã được đặt thành công!</h2>
                    <p class="text-muted">
                        Mã đơn hàng:
                        <strong class="text-primary">#{{ $order->id }}</strong>
                    </p>
                    <p class="text-muted">Chúng tôi sẽ liên hệ sớm để xác nhận đơn hàng của bạn.</p>
                </div>

                {{-- 🧾 Thông tin đơn hàng --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">📦 Thông tin đơn hàng</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Người nhận</p>
                                <p class="fw-bold">
                                    {{ $order->customer_name ?? $order->customer->fullname ?? '—' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Số điện thoại</p>
                                <p class="fw-bold">
                                    {{ $order->customer_phone ?? $order->customer->tel ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="text-muted mb-1">Địa chỉ giao hàng</p>
                                <p class="fw-bold">
                                    {{ $order->customer_address ?? $order->customer->address ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Phương thức thanh toán</p>
                                <p class="fw-bold">
                                    @if ($order->payment_method == 'cod')
                                        💵 Thanh toán khi nhận hàng
                                    @elseif ($order->payment_method == 'momo')
                                        🎀 Ví MoMo
                                    @else
                                        🔘 Không xác định
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Trạng thái thanh toán</p>
                                <p class="fw-bold">
                                    @if ($order->payment_method === 'momo')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @elseif ($order->payment_method === 'cod')
                                        <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                    @else
                                        <span class="badge bg-secondary">Chưa xác định</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p class="text-muted mb-1">Ngày đặt hàng</p>
                            <p class="fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- 🛍️ Sản phẩm trong đơn --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">🛍️ Sản phẩm đã đặt</h5>

                        <div class="table-responsive">
                            <table class="table align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>STT</th>
                                        <th>Hình</th>
                                        <th>Sản phẩm</th>
                                        <th>Màu sắc</th>
                                        <th>Phiên bản</th>
                                        <th>SL</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @php
                                                    $imagePath = $item->product && $item->product->fileName
                                                        ? asset('storage/products/' . $item->product->fileName)
                                                        : asset('images/no-image.png');
                                                @endphp
                                                <img src="{{ $imagePath }}" width="70" height="70" class="rounded-2"
                                                    style="object-fit: cover;">
                                            </td>
                                            <td class="text-start">{{ $item->product->proname ?? 'Sản phẩm không tồn tại' }}</td>
                                            <td>{{ $item->color ?? '—' }}</td>
                                            <td>{{ $item->version ?? '—' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                            <td class="fw-bold text-danger">
                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="fw-bold table-light">
                                    <tr>
                                        <td colspan="7" class="text-end">Tổng cộng:</td>
                                        <td class="text-danger fs-5">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 🔙 Nút hành động --}}
                <div class="text-center mt-4">
                    <a href="{{ route('homepage') }}" class="btn btn-primary btn-lg px-5 me-3"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                        🏠 Về trang chủ
                    </a>
                    <a href="{{ route('client.products.index') }}" class="btn btn-outline-primary btn-lg px-5">
                        🛍️ Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ CSS animation checkmark --}}
    <style>
        .success-checkmark {
            width: 80px;
            height: 115px;
            margin: 0 auto;
        }
        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4CAF50;
            background-color: #4CAF50;
        }
        .success-checkmark .icon-line {
            height: 5px;
            background-color: #fff;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }
        .success-checkmark .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s;
        }
        .success-checkmark .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s;
        }
        .success-checkmark .icon-circle {
            top: -4px;
            left: -4px;
            z-index: 10;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            box-sizing: content-box;
            border: 4px solid rgba(76, 175, 80, .5);
        }
        .success-checkmark .icon-fix {
            top: 8px;
            width: 5px;
            left: 26px;
            z-index: 1;
            height: 85px;
            position: absolute;
            transform: rotate(-45deg);
            background-color: #fff;
        }
        @keyframes icon-line-tip {
            0% { width: 0; left: 1px; top: 19px; }
            70% { width: 50px; left: -8px; top: 37px; }
            100% { width: 25px; left: 14px; top: 45px; }
        }
        @keyframes icon-line-long {
            0% { width: 0; right: 46px; top: 54px; }
            84% { width: 55px; right: 0px; top: 35px; }
            100% { width: 47px; right: 8px; top: 38px; }
        }
    </style>
@endsection
