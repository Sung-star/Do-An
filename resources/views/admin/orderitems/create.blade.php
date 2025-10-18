@extends('layout.admin')
@section('title', 'Thêm chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-success">📝 Thêm chi tiết đơn hàng</h2>

    <form method="POST" action="{{ route('ad.orderitems.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Đơn hàng</label>
            <select name="orderid" class="form-select" required>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">#{{ $order->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Sản phẩm</label>
            <select name="productid" class="form-select" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->proname }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Màu sắc</label>
                <input type="text" name="color" class="form-control" placeholder="VD: Đen, Trắng, Xanh...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Phiên bản</label>
                <input type="text" name="version" class="form-control" placeholder="VD: 128GB, 256GB...">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" min="0" step="0.01" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">💾 Lưu</button>
        <a href="{{ route('ad.orderitems.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>
@endsection
