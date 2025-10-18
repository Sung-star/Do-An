@extends('layout.admin')
@section('title', 'Sửa chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-warning">✏️ Sửa chi tiết đơn hàng</h2>

    <form method="POST" action="{{ route('ad.orderitems.update', $item->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Đơn hàng</label>
            <select name="orderid" class="form-select">
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" {{ $item->orderid == $order->id ? 'selected' : '' }}>#{{ $order->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Sản phẩm</label>
            <select name="productid" class="form-select">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $item->productid == $product->id ? 'selected' : '' }}>
                        {{ $product->proname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Màu sắc</label>
                <input type="text" name="color" class="form-control" value="{{ $item->color }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Phiên bản</label>
                <input type="text" name="version" class="form-control" value="{{ $item->version }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ $item->price }}" min="0" step="0.01">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
        <a href="{{ route('ad.orderitems.index') }}" class="btn btn-secondary">← Quay lại</a>
    </form>
</div>
@endsection
