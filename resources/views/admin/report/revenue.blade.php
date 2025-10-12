@extends('layout.admin')

@section('title', 'Báo cáo doanh thu')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📊 Báo cáo Doanh thu</h2>

    {{-- Thống kê tổng quan --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Doanh thu hôm nay</h5>
                    <p class="fs-4 mb-0">{{ number_format($todayRevenue, 0, ',', '.') }} đ</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Tổng doanh thu</h5>
                    <p class="fs-4 mb-0">{{ number_format($totalRevenue, 0, ',', '.') }} đ</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5>Đơn hàng đã hoàn thành</h5>
                    <p class="fs-4 mb-0">{{ $completedOrders }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Danh sách đơn hàng --}}
    <h4 class="mt-5">📦 Danh sách Đơn hàng</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->fullname ?? 'Khách lẻ' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge 
                            @if($order->status === 'Hoàn thành') bg-success
                            @elseif($order->status === 'Chờ xử lý') bg-warning
                            @else bg-secondary @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
