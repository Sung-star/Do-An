@extends('layout.client')

@section('content')
    @php
        $cart = Session::get('cart', []);
        $total = 0;
    @endphp

    <section class="py-5">
        <div class="container">
            <h3 class="mb-4 text-primary fw-bold">🛒 Giỏ hàng của bạn</h3>

            @if (count($cart) == 0)
                <div class="alert alert-warning text-center py-4 rounded-3 shadow-sm">
                    Chưa có sản phẩm nào trong giỏ hàng!
                </div>
            @else
                <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                    <table class="table align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Hình</th>
                                <th>Sản phẩm</th>
                                <th>Màu sắc</th>
                                <th>Phiên bản</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @php
                                            $image = $item['fileName']
                                                ? asset('storage/products/' . $item['fileName'])
                                                : asset('images/no-image.png');
                                        @endphp
                                        <img src="{{ $image }}" width="70" height="70" class="rounded-2" style="object-fit: cover;">
                                    </td>

                                    <td class="fw-semibold text-start">{{ $item['proname'] }}</td>
                                    <td>{{ $item['color'] ?? '—' }}</td>
                                    <td>{{ $item['version'] ?? '—' }}</td>

                                    <td style="width: 160px;">
                                        <form action="{{ route('cart.updateQty', $item['key']) }}" method="POST"
                                            class="d-flex justify-content-center align-items-center">
                                            @csrf
                                            <button type="submit" name="action" value="decrease"
                                                class="btn btn-sm btn-outline-secondary">−</button>
                                            <input type="text" name="quantity" value="{{ $item['quantity'] }}"
                                                class="form-control text-center mx-1" readonly style="width: 45px;">
                                            <button type="submit" name="action" value="increase"
                                                class="btn btn-sm btn-outline-secondary">+</button>
                                        </form>
                                    </td>

                                    <td>{{ number_format($item['price']) }}đ</td>
                                    <td class="text-danger fw-semibold">{{ number_format($subtotal) }}đ</td>

                                    <td>
                                        <a href="{{ route('cartdel', ['key' => $item['key']]) }}"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold table-light">
                                <td colspan="7" class="text-end">Tổng cộng</td>
                                <td class="text-danger fs-5">{{ number_format($total) }}đ</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-end">
                                    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg me-2">
                                        🧾 Tiến hành đặt hàng
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    <style>
        [data-theme="dark"] .table-dark {
            background: #0f172a;
            color: #e2e8f0;
        }

        [data-theme="dark"] .table-light {
            background: #1e293b !important;
            color: #f8fafc !important;
        }

        [data-theme="dark"] .btn-outline-danger {
            color: #f87171;
            border-color: #ef4444;
        }

        [data-theme="dark"] .btn-outline-danger:hover {
            background: #ef4444;
            color: #fff;
        }

        [data-theme="dark"] .btn-success {
            background: #22c55e !important;
        }

        [data-theme="dark"] .alert-warning {
            background: #facc15 !important;
            color: #000 !important;
        }
    </style>
@endsection
