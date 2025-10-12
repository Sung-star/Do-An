@extends('layout.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>

    {{-- ================== Cards Thống kê ================== --}}
    <div class="row my-4">
    {{-- Tổng sản phẩm --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                Tổng sản phẩm: {{ $totalProducts }}
            </div>
            <div class="card-footer">
                <a href="{{ route('pro2.index') }}" class="text-white small stretched-link">Xem chi tiết</a>
            </div>
        </div>
    </div>

    {{-- Tổng đơn hàng --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                Tổng đơn hàng: {{ $totalOrders }}
            </div>
            <div class="card-footer">
                <a href="{{ route('ad.orders.index') }}" class="text-white small stretched-link">Xem chi tiết</a>
            </div>
        </div>
    </div>

    {{-- Tổng khách hàng --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-dark mb-4">
            <div class="card-body">
                Tổng khách hàng: {{ $totalCustomers }}
            </div>
            <div class="card-footer">
                <a href="{{ route('ad.customers.index') }}" class="text-dark small stretched-link">Xem chi tiết</a>
            </div>
        </div>
    </div>

    {{-- Doanh thu hôm nay --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                Doanh thu hôm nay: {{ number_format($todayRevenue) }} đ
            </div>
            <div class="card-footer">
                <a href="{{ route('report.revenue') }}" class="text-white small stretched-link">Xem chi tiết</a>
            </div>
        </div>
    </div>
</div>


    {{-- ================== Biểu đồ doanh thu ================== --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Doanh thu theo tháng ({{ date('Y') }})
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    {{-- ================== Sản phẩm mới nhất ================== --}}
    <h4 class="mt-4">Sản phẩm mới nhất</h4>
    <div class="card mb-4">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->proname }}</td>
                        <td>
                            <img src="{{ asset('storage/products/' . $product->fileName) }}"
                                alt="{{ $product->proname }}" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td>{{ number_format($product->price) }} đ</td>
                        <td>{{ optional($product->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================== Đơn hàng mới nhất ================== --}}
    <h4 class="mt-4">Đơn hàng mới nhất</h4>
    <div class="card mb-4">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestOrders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer->fullname ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status === 'Hoàn thành' ? 'success' : 'warning' }}">
                                {{ $order->status ?? 'Chờ xử lý' }}
                            </span>
                        </td>
                        <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================== Đơn hàng chờ xử lý ================== --}}
    <h4 class="mt-4">Đơn hàng chờ xử lý</h4>
    <div class="card mb-4">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingOrders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer->fullname ?? 'N/A' }}</td>
                        <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
