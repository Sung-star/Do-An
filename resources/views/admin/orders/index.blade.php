@extends('layout.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="container">
        <h2 class="my-4 text-primary">
            <i class="fas fa-boxes"></i> Danh sách đơn hàng
        </h2>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center shadow-sm">
                <thead class="table-dark text-light">
                    <tr>
                        <th>ID Đơn hàng</th>
                        <th>👤 Khách hàng</th>
                        <th>📅 Ngày tạo</th>
                        <th>📦 Trạng thái</th> {{-- ✅ thêm --}}
                        <th>🛒 Tổng sản phẩm</th>
                        <th>📝 Ghi chú</th>
                        <th>🔍 Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->customer_name ?? ($order->customer->fullname ?? '—') }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

                            {{-- ✅ Hiển thị trạng thái --}}
                            <td>
                                @switch($order->status)
                                    @case('Chờ xử lý')
                                        <span class="badge bg-warning text-dark">⏳ Chờ xử lý</span>
                                    @break

                                    @case('Đang xử lý')
                                        <span class="badge bg-info">🔄 Đang xử lý</span>
                                    @break

                                    @case('Hoàn thành')
                                        <span class="badge bg-success">✅ Hoàn thành</span>
                                    @break

                                    @case('Đã hủy')
                                        <span class="badge bg-danger">❌ Đã hủy</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endswitch

                            </td>

                            <td><span class="badge bg-success">{{ $order->items->count() }} sản phẩm</span></td>

                            <td>{{ $order->description ?? 'Không có ghi chú' }}</td>
                            <td>
                                <a href="{{ route('ad.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    @endsection
