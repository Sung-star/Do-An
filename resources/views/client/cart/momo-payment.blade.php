@extends('layout.client')

@section('content')
    <div class="py-5" style="background: linear-gradient(135deg, #a8216b 0%, #d91e7a 100%); min-height: 200px;">
        <div class="container text-center text-white">
            <h1 class="display-5 fw-bold mb-2">💳 Thanh toán MoMo</h1>
            <p class="lead">Quét mã QR để hoàn tất thanh toán</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5 text-center">
                        <!-- Logo MoMo -->
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex p-3"
                                style="width: 100px; height: 100px; align-items: center; justify-content: center;">
                                <span style="font-size: 50px;">🎀</span>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-2">Quét mã QR để thanh toán</h3>
                        <p class="text-muted mb-4">Vui lòng mở ứng dụng MoMo và quét mã QR bên dưới</p>

                        <!-- QR Code -->
                        <div class="mb-4 p-4 bg-light rounded">
                            <img src="{{ $qrCodeUrl }}" alt="MoMo QR Code" class="img-fluid" style="max-width: 300px;">
                        </div>

                        <!-- Thông tin thanh toán -->
                        <div class="bg-light p-4 rounded mb-4 text-start">
                            <div class="row mb-3">
                                <div>Mã đơn hàng: <strong>Đơn hàng {{ $order->id }}</strong></div>
                                <div>Số tiền: <strong>{{ number_format($total, 0, ',', '.') }}đ</strong></div>
                                <div>Nội dung: <strong>{{ $momoInfo['note'] }}</strong></div>
                                <div>Người nhận: <strong>{{ $customerInfo['name'] }}</strong></div>
                            </div>

                            <!-- Hướng dẫn -->
                            <div class="alert alert-info text-start">
                                <h6 class="fw-bold mb-2">📱 Hướng dẫn thanh toán:</h6>
                                <ol class="mb-0 ps-3">
                                    <li>Mở ứng dụng MoMo trên điện thoại</li>
                                    <li>Chọn "Quét mã QR"</li>
                                    <li>Quét mã QR phía trên</li>
                                    <li>Kiểm tra thông tin và xác nhận thanh toán</li>
                                </ol>
                            </div>

                            <!-- Nút xác nhận -->
                            <form action="{{ route('checkout.confirm-momo', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-lg w-100 fw-bold text-white mb-3"
                                    style="background: linear-gradient(135deg, #a8216b 0%, #d91e7a 100%); border: none; border-radius: 10px; padding: 15px;">
                                    ✅ Tôi đã thanh toán
                                </button>
                            </form>

                            <a href="{{ route('cartshow') }}" class="btn btn-outline-secondary w-100">
                                ← Quay lại giỏ hàng
                            </a>

                            <!-- Countdown Timer -->
                            <div class="mt-4">
                                <p class="text-muted small">
                                    ⏰ Vui lòng hoàn tất thanh toán trong <span id="countdown"
                                        class="fw-bold text-danger">15:00</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Hoặc thanh toán thủ công -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">💰 Hoặc chuyển khoản thủ công:</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-2"><strong>Số điện thoại MoMo:</strong> {{ $momoInfo['phone'] }}</p>
                                <p class="mb-2"><strong>Tên người nhận:</strong> HOAL SUNG SHOP</p>
                                <p class="mb-2"><strong>Số tiền:</strong> <span
                                        class="text-danger fw-bold">{{ number_format($momoInfo['amount']) }}₫</span></p>
                                <p class="mb-0"><strong>Nội dung CK:</strong> <span
                                        class="badge bg-primary">{{ $momoInfo['note'] }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            .card {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            #countdown {
                font-size: 1.2rem;
            }
        </style>

        <script>
            // Countdown timer 15 phút
            let timeLeft = 15 * 60; // 15 minutes in seconds

            function updateCountdown() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('countdown').textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft === 0) {
                    alert('Hết thời gian thanh toán! Vui lòng đặt hàng lại.');
                    window.location.href = '{{ route('cartshow') }}';
                }

                timeLeft--;
            }

            // Update every second
            setInterval(updateCountdown, 1000);
            updateCountdown();

            // Auto refresh status every 5 seconds (kiểm tra xem đã thanh toán chưa)
            setInterval(function() {
                fetch('{{ route('checkout.check-payment-status', $order->id) }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.paid) {
                            window.location.href = '{{ route('checkout.success', $order->id) }}';
                        }
                    });
            }, 5000);
        </script>
    @endsection
