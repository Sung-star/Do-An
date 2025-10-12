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
                <div class="alert alert-warning">Chưa có sản phẩm nào trong giỏ hàng!</div>
            @else
                <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                    <table class="table align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Hình sản phẩm</th>
                                <th>Sản phẩm</th>
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
                                            $hasImage = isset($item['fileName']) && $item['fileName'] != '';
                                            $imagePath = $hasImage
                                                ? asset('storage/products/' . $item['fileName'])
                                                : asset('images/no-image.png');
                                        @endphp
                                        <img src="{{ $imagePath }}" width="70" height="70" style="object-fit: cover;"
                                            class="rounded-2" />
                                    </td>

                                    <td>{{ $item['proname'] }}</td>
                                    <td style="width: 160px;">
                                        <form action="{{ route('cart.updateQty', $item['productid']) }}" method="POST"
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
                                        <a href="{{ route('cartdel', ['id' => $item['productid']]) }}"
                                            class="btn btn-sm btn-outline-danger">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold table-light">
                                <td colspan="5" class="text-end">Tổng cộng</td>
                                <td class="text-danger">{{ number_format($total) }}đ</td>
                                <td></td>
                            </tr>
                            <tr>
                            <td colspan="7" class="text-end">
    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg me-2">🧾 Tiến hành đặt hàng</a>
</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection
