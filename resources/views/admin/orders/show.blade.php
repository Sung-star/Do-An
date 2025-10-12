@extends('layout.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">
            <i class="fas fa-receipt"></i> Chi tiết đơn hàng #{{ $order->id }}
        </h2>

        {{-- ================= Thông tin khách hàng ================= --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <strong>Thông tin khách hàng</strong>
            </div>
            <div class="card-body">
                <p><strong>👤 Họ tên:</strong> {{ $order->customer->fullname }}</p>
                <p><strong>📞 SĐT:</strong> {{ $order->customer->tel }}</p>
                <p><strong>📧 Email:</strong> {{ $order->customer->email ?? '—' }}</p>
            </div>
        </div>

        {{-- ================= Thông tin đơn hàng ================= --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <strong>Thông tin đơn hàng</strong>
            </div>
            <div class="card-body">
                <p><strong>🆔 Mã đơn:</strong> {{ $order->id }}</p>
                <p><strong>📅 Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>📦 Tổng sản phẩm:</strong> {{ $order->items->count() }}</p>

                {{-- 💳 Phương thức thanh toán --}}
                <p>
                    <strong>💳 Phương thức thanh toán:</strong>
                    @if ($order->payment_method === 'momo')
                        <span class="badge bg-warning text-dark">MoMo</span>
                    @elseif ($order->payment_method === 'cod')
                        <span class="badge bg-success">Thanh toán khi nhận hàng (COD)</span>
                    @else
                        <span class="badge bg-secondary">{{ $order->payment_method ?? 'Chưa xác định' }}</span>
                    @endif
                </p>

                {{-- 📌 Trạng thái thanh toán --}}
                <p>
                    <strong>💰 Trạng thái thanh toán:</strong>
                    @if ($order->payment_method === 'momo')
                        <span class="badge bg-success">Đã thanh toán</span>
                    @elseif ($order->payment_method === 'cod')
                        <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                    @else
                        <span class="badge bg-danger">Chưa thanh toán</span>
                    @endif
                </p>

                {{-- ✅ Form cập nhật trạng thái đơn hàng --}}
                <form action="{{ route('ad.orders.updateStatus', $order->id) }}" method="POST"
                      class="d-flex align-items-center mt-3">
                    @csrf
                    @method('PATCH')

                    <label for="status" class="me-2"><strong>📌 Trạng thái đơn hàng:</strong></label>
                    <select name="status" id="status" class="form-select w-auto me-2">
                        <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                        <option value="Đang xử lý" {{ $order->status == 'Đang xử lý' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                        <option value="Hoàn thành" {{ $order->status == 'Hoàn thành' ? 'selected' : '' }}>✅ Hoàn thành</option>
                        <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>❌ Đã hủy</option>
                    </select>

                    <button type="submit" class="btn btn-primary">💾 Lưu</button>
                </form>
            </div>
        </div>

        {{-- ================= Danh sách sản phẩm trong đơn ================= --}}
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <strong>Danh sách sản phẩm</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->product_name ?? 'Sản phẩm đã xóa' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <h5><strong>Tổng tiền:</strong>
                        {{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }} đ
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection
