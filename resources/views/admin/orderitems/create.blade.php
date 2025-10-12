@extends('layout.admin')
@section('title', 'Thêm chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4">📝 Thêm chi tiết đơn hàng</h2>
    <form method="POST" action="{{ route('ad.orderitems.store') }}">
        @csrf
        <div class="mb-3">
            <label>Đơn hàng</label>
            <select name="orderid" class="form-control">
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">#{{ $order->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Sản phẩm</label>
            <select name="productid" class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->proname }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="quantity" class="form-control">
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
