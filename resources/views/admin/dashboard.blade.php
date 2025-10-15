@extends('layout.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
    <p class="text-muted mb-4">Tổng quan hoạt động hệ thống năm {{ date('Y') }}</p>

    {{-- ========== Cards thống kê ========== --}}
    @php
        // Giả lập dữ liệu tăng trưởng (trong thực tế bạn có thể lấy từ DB)
        $growthData = [
            'products' => 12.3,   // +12.3%
            'orders' => -8.5,     // -8.5%
            'customers' => 0,     // Không đổi
            'revenue' => 15.8     // +15.8%
        ];

        $cards = [
            [
                'title' => 'Tổng sản phẩm',
                'value' => $totalProducts ?? 0,
                'icon' => 'bi-box-seam',
                'color' => 'primary',
                'growth' => $growthData['products'],
                'route' => 'pro2.index'
            ],
            [
                'title' => 'Tổng đơn hàng',
                'value' => $totalOrders ?? 0,
                'icon' => 'bi-receipt',
                'color' => 'success',
                'growth' => $growthData['orders'],
                'route' => 'ad.orders.index'
            ],
            [
                'title' => 'Tổng khách hàng',
                'value' => $totalCustomers ?? 0,
                'icon' => 'bi-people-fill',
                'color' => 'warning',
                'growth' => $growthData['customers'],
                'route' => 'ad.customers.index'
            ],
            [
                'title' => 'Doanh thu hôm nay',
                'value' => $todayRevenue ?? 0,
                'icon' => 'bi-graph-up-arrow',
                'color' => 'danger',
                'growth' => $growthData['revenue'],
                'route' => 'report.revenue'
            ],
        ];
    @endphp

    <div class="row g-4 mb-4">
        @foreach ($cards as $card)
            @php
                $growth = $card['growth'];
                $isUp = $growth > 0;
                $isDown = $growth < 0;
                $growthColor = $isUp ? 'text-success' : ($isDown ? 'text-danger' : 'text-secondary');
                $growthIcon = $isUp ? 'bi-arrow-up' : ($isDown ? 'bi-arrow-down' : 'bi-dash');
            @endphp

            <div class="col-xl-3 col-md-6 fade-card">
                <div class="card shadow-sm border-0 h-100 stat-card bg-mode-{{ $card['color'] }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-semibold mb-1">{{ $card['title'] }}</h6>
                            <h3 class="fw-bold mb-0 counter" data-target="{{ $card['value'] }}">
                                {{ number_format($card['value']) }}
                            </h3>
                            <small class="{{ $growthColor }} fw-medium">
                                <i class="bi {{ $growthIcon }}"></i>
                                {{ $growth != 0 ? number_format($growth, 1) . '%' : 'Không đổi' }}
                                so với tháng trước
                            </small>
                        </div>
                        <i class="bi {{ $card['icon'] }} fs-1 opacity-75"></i>
                    </div>
                    <div class="card-footer border-0 text-center bg-transparent">
                        <a href="{{ route($card['route']) }}" class="small text-decoration-none link-muted">
                            Xem chi tiết <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ========== Biểu đồ doanh thu ========== --}}
    <div class="card mb-4 shadow-sm border-0 fade-card chart-card">
        <div class="card-header fw-semibold d-flex align-items-center bg-mode-header">
            <i class="fas fa-chart-bar me-2 text-primary"></i>Doanh thu theo tháng ({{ date('Y') }})
        </div>
        <div class="card-body bg-mode-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    {{-- ========== Sản phẩm mới nhất ========== --}}
    <h4 class="fw-bold text-secondary mt-4 mb-3 fade-card"><i class="bi bi-bag-check-fill me-2"></i>Sản phẩm mới nhất</h4>
    <div class="card mb-4 shadow-sm border-0 fade-card bg-mode-body">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center table-mode">
                <thead class="table-mode-header">
                    <tr>
                        <th>#</th>
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
                                    alt="{{ $product->proname }}"
                                    class="img-thumbnail"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td class="fw-semibold">{{ number_format($product->price) }} đ</td>
                            <td>{{ optional($product->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========== Đơn hàng mới nhất ========== --}}
    <h4 class="fw-bold text-secondary mt-4 mb-3 fade-card"><i class="bi bi-receipt-cutoff me-2"></i>Đơn hàng mới nhất</h4>
    <div class="card mb-4 shadow-sm border-0 fade-card bg-mode-body">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0 align-middle text-center table-mode">
                <thead class="table-mode-header">
                    <tr>
                        <th>#</th>
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

    {{-- ========== Đơn hàng chờ xử lý ========== --}}
    <h4 class="fw-bold text-secondary mt-4 mb-3 fade-card"><i class="bi bi-hourglass-split me-2"></i>Đơn hàng chờ xử lý</h4>
    <div class="card mb-5 shadow-sm border-0 fade-card bg-mode-body">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle text-center table-mode">
                <thead class="table-mode-header">
                    <tr>
                        <th>#</th>
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
    // === Biểu đồ doanh thu ===
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: '#4e73df',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' đ'
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { color: '#666' } },
                x: { ticks: { color: '#666' } }
            }
        }
    });

    // === Counter hiệu ứng ===
    document.querySelectorAll('.counter').forEach(counter => {
        const update = () => {
            const target = +counter.dataset.target;
            const value = +counter.innerText.replace(/\./g, '');
            const inc = target / 50;
            if (value < target) {
                counter.innerText = Math.ceil(value + inc).toLocaleString('vi-VN');
                requestAnimationFrame(update);
            } else {
                counter.innerText = target.toLocaleString('vi-VN');
                counter.classList.add('pulse');
            }
        };
        update();
    });

    // === Fade-in cards ===
    document.querySelectorAll('.fade-card').forEach((c, i) => {
        setTimeout(() => c.classList.add('fade-show'), i * 120);
    });
</script>

<style>
    /* ========= Dark/Light Mode Styles ========= */
    .bg-mode-primary { background-color: var(--bs-primary)!important; color:#fff!important; }
    .bg-mode-success { background-color: var(--bs-success)!important; color:#fff!important; }
    .bg-mode-warning { background-color: #f6c23e!important; color:#212529!important; }
    .bg-mode-danger { background-color: var(--bs-danger)!important; color:#fff!important; }

    body.dark-mode .stat-card {
        background-color: #2b2f44!important;
        color: #f0f0f0!important;
        border: 1px solid #3e435a!important;
    }
    body.dark-mode .link-muted { color: #ccc!important; }
    body.dark-mode .chart-card, body.dark-mode .bg-mode-body { background-color: #22263a!important; }
    body.dark-mode .bg-mode-header { background-color: #1b1e2f!important; color: #ddd!important; }
    body.dark-mode .table-mode { color: #eee!important; }
    body.dark-mode .table-mode-header { background-color: #3b3f54!important; color: #fff!important; }

    .fade-card { opacity: 0; transform: translateY(20px); transition: all 0.6s ease; }
    .fade-card.fade-show { opacity: 1; transform: translateY(0); }

    @keyframes pulseGlow {
        0% { text-shadow: 0 0 0 transparent; }
        50% { text-shadow: 0 0 8px rgba(255,255,255,.8); }
        100% { text-shadow: 0 0 0 transparent; }
    }
    .pulse { animation: pulseGlow 1.5s ease-in-out; }

    .table-mode th, .table-mode td { vertical-align: middle; }
    .table-mode-header { background-color: #343a40; color: #fff; }
    body:not(.dark-mode) .bg-mode-body { background-color: #fff; }
    body:not(.dark-mode) .bg-mode-header { background-color: #f8f9fc; }
</style>
@endsection
