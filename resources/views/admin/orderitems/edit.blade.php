@extends('layout.admin')
@section('title', 'Sửa chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4">✏️ Sửa chi tiết đơn hàng</h2>
    <form method="POST" action="{{ route('ad.orderitems.update', $item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Đơn hàng</label>
            <select name="orderid" class="form-control">
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" {{ $item->orderid == $order->id ? 'selected' : '' }}>#{{ $order->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Sản phẩm</label>
            <select name="productid" class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $item->productid == $product->id ? 'selected' : '' }}>{{ $product->proname }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}">
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ $item->price }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
