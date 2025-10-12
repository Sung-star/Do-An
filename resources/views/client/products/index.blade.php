@extends('layout.client')

@section('content')
    <h2 class="text-center fw-bold text-primary py-4">🌈 Tất cả sản phẩm 🌟</h2>
    <section class="py-4" style="background: linear-gradient(to bottom right, #ffe29a, #ffa99f);">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $item)
                    <div class="col mb-4">
                        <div class="card h-100 shadow-lg border border-3 border-purple rounded-4"
                            style="background: linear-gradient(to bottom right, #fff3cd, #ffe0e9);">
                            <!-- Product image-->
                            <img class="card-img-top p-2 rounded-4" src="{{ asset('storage/products/' . $item->fileName) }}"
                                alt="{{ $item->proname }}" style="height: 200px; object-fit: cover;">

                            <!-- Product details-->
                            <div class="card-body px-3 py-2">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bold text-dark" style="text-shadow: 1px 1px 2px #fff;">
                                        {{ $item->proname }}</h5>
                                    <!-- Product price-->
                                    <span class="badge bg-danger fs-6 mt-2">{{ number_format($item->price) }}đ</span>
                                </div>
                            </div>

                            <!-- Product actions-->
                            <div class="card-footer d-flex justify-content-between px-3 pb-3 bg-transparent border-top-0">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('client.products.detail', $item->id) }}">👁️ Xem</a>
                                <form action="{{ route('cartadd', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">🛒 Thêm vào giỏ hàng</button>
                                </form>
                                <a href="{{ url('/cartshow') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                                    <i class="bi bi-cart-plus"></i> Đặt hàng
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
