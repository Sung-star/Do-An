@extends('layout.client')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2>Sản phẩm theo thương hiệu: {{ $brand->brandname }}</h2>

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @forelse ($brand->products as $item)
                    <div class="col mb-3">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ asset('storage/products/' . $item->fileName) }}"
                                alt="{{ $item->proname }}">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    <h4 class="fw-bolder">{{ $item->proname }}</h4>
                                    <span class="text-danger">{{ number_format($item->price) }}đ</span>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center d-flex justify-content-center">
                                    <a class="btn btn-primary mt-auto"
                                        href="{{ route('client.products.detail', $item->id) }}">Xem</a>
                                    <form action="{{ route('cartadd', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="submit" class="btn btn-outline-primary mt-auto" value="Đặt hàng">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Không có sản phẩm nào thuộc thương hiệu này.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
