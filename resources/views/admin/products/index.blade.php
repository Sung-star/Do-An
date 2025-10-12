@extends('layout.admin')

@section('title', 'Sản phẩm')

@section('content')
    <div class="container mt-4">
        <h3>Danh sách sản phẩm</h3>
        <a href="{{ route('pro.create') }}" class="btn btn-primary mb-3">+ Thêm</a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Loại</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->catename }}</td>
                        <td>{{ $item->productname }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">sửa</a>
                            <a href="#" class="btn btn-danger btn-sm">xóa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $list->links('pagination::bootstrap-4') }}

@endsection
