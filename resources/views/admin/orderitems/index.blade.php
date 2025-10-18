@extends('layout.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-primary">
        <i class="fas fa-box-open"></i> Danh sách chi tiết đơn hàng
    </h2>

    <a href="{{ route('ad.orderitems.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Thêm mới
    </a>

    <table class="table table-bordered table-hover align-middle text-center shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Phiên bản</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>#{{ $item->orderid }}</td>
                    <td>{{ $item->product->proname ?? '—' }}</td>
                    <td>{{ $item->color ?? '—' }}</td>
                    <td>{{ $item->version ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td class="fw-bold text-danger">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ
                    </td>
                    <td>
                        <a href="{{ route('ad.orderitems.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            ✏️ Sửa
                        </a>
                        <form action="{{ route('ad.orderitems.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa mục này?')">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
