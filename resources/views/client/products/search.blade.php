@extends('layout.client')

@section('content')
    <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>
    @if ($products->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($products as $item)
                        <div class="col mb-3">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ asset('storage/products/' . $item->fileName) }}" />
                                <!-- Product details-->
                                <div class="card-body p-2">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h4 class="fw-bolder">{{ $item->proname }}</h4>
                                        <!-- Product price-->
                                        <span class="text-danger">{{ number_format($item->price) }}đ</span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <form
                                    class="card-footer d-flex justify-content-between px-3 pb-3 bg-transparent border-top-0">
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('client.products.detail', $item->id) }}">👁️ Xem</a>
                                    <form action="{{ route('cartadd', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"> Thêm vào giỏ hàng</button>
                                    </form>
                                    <a href="{{ url('/cartshow') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                                        <i class="bi bi-cart-plus"></i>🛒 Đặt hàng
                                    </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
    @endforeach
    </div>
    </div>
    </section>
    @endif
@endsection
