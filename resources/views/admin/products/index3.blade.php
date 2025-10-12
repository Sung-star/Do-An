@extends('layout.admin')

@section('title', 'Sản phẩm')

@section('content')
    <div class="container mt-4">
        <h3>Danh sách sản phẩm</h3>
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <a href="{{ route('pro.create') }}" class="btn btn-primary mb-3">+ Thêm</a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Loại</th>
                    <th>Thương hiệu</th>
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
                        <td>{{ $item->brandname }}</td>
                        <td>{{ $item->productname }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('pro.edit', $item->id) }}" class="btn btn-warning mx-1">sửa</a>
                                <form action="{{ route('pro.delete', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mx-1">xóa</button>
                                </form>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target = "#confirmdelete" data-info="{{ $item->productname }}"
                                    data-action="{{ route('pro.delete', $item->id) }}">
                                    Xóa (modal)
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $list->links('pagination::bootstrap-4') }}

    {{-- <div class="modal fade" id="confirmdelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="info">....</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <x-modal></x-modal>
@endsection
