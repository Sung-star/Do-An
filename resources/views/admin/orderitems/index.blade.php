@extends('layout.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4">📦 Danh sách chi tiết đơn hàng</h2>

    <a href="{{ route('ad.orderitems.create') }}" class="btn btn-primary mb-3">+ Thêm mới</a>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>#{{ $item->orderid }}</td>
                    <td>{{ $item->product->proname ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td>
                        <a href="{{ route('ad.orderitems.edit', $item->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('ad.orderitems.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
