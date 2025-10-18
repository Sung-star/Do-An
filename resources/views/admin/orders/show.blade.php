@extends('layout.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary"><i class="fas fa-receipt"></i> Chi tiết đơn hàng #{{ $order->id }}</h2>

    {{-- 🧍‍♂️ Thông tin khách hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white"><strong>Thông tin khách hàng</strong></div>
        <div class="card-body">
            <p><strong>👤 Họ tên:</strong> {{ $order->customer_name ?? $order->customer->fullname ?? '—' }}</p>
            <p><strong>📞 SĐT:</strong> {{ $order->customer_phone ?? $order->customer->tel ?? '—' }}</p>
            <p><strong>📧 Email:</strong> {{ $order->customer_email ?? $order->customer->email ?? '—' }}</p>
            <p><strong>🏠 Địa chỉ:</strong> {{ $order->customer_address ?? $order->customer->address ?? '—' }}</p>
        </div>
    </div>

    {{-- 🧾 Thông tin đơn hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white"><strong>Thông tin đơn hàng</strong></div>
        <div class="card-body">
            <p><strong>🆔 Mã đơn:</strong> #{{ $order->id }}</p>
            <p><strong>📅 Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>📦 Tổng sản phẩm:</strong> {{ $order->items->count() }}</p>

            <p><strong>💳 Phương thức thanh toán:</strong>
                @if ($order->payment_method === 'momo')
                    <span class="badge bg-warning text-dark">MoMo</span>
                @elseif ($order->payment_method === 'cod')
                    <span class="badge bg-success">Thanh toán khi nhận hàng (COD)</span>
                @else
                    <span class="badge bg-secondary">Không xác định</span>
                @endif
            </p>

            <p><strong>💰 Trạng thái thanh toán:</strong>
                @if ($order->payment_method === 'momo')
                    <span class="badge bg-success">Đã thanh toán</span>
                @elseif ($order->payment_method === 'cod')
                    <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                @else
                    <span class="badge bg-secondary">Chưa xác định</span>
                @endif
            </p>

            <form action="{{ route('ad.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center mt-3">
                @csrf @method('PATCH')
                <label class="me-2"><strong>📌 Trạng thái đơn hàng:</strong></label>
                <select name="status" class="form-select w-auto me-2">
                    <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                    <option value="Đang xử lý" {{ $order->status == 'Đang xử lý' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                    <option value="Hoàn thành" {{ $order->status == 'Hoàn thành' ? 'selected' : '' }}>✅ Hoàn thành</option>
                    <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>❌ Đã hủy</option>
                </select>
                <button type="submit" class="btn btn-primary">💾 Lưu</button>
            </form>
        </div>
    </div>

    {{-- 🛍️ Danh sách sản phẩm --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white"><strong>Danh sách sản phẩm</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Hình</th>
                        <th>Sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Phiên bản</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @php
                                    $img = $item->product?->fileName ? asset('storage/products/' . $item->product->fileName) : asset('images/no-image.png');
                                @endphp
                                <img src="{{ $img }}" width="70" height="70" style="object-fit:cover" class="rounded-2">
                            </td>
                            <td>{{ $item->product->proname ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ $item->color ?? '—' }}</td>
                            <td>{{ $item->version ?? '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} đ</td>
                            <td class="text-danger fw-bold">{{ number_format($item->price * $item->quantity) }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="7" class="text-end">Tổng tiền:</td>
                        <td class="text-danger fs-5">{{ number_format($order->total_amount) }} đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
