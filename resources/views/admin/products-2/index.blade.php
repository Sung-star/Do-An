@extends('layout.admin')

@section('title', 'Sản phẩm')

@section('content')
<div class="container mt-4">
    <h3>Danh sách sản phẩm (Eloquent ORM)</h3>

    <x-alert></x-alert>

    {{-- Nút thêm --}}
    <a href="{{ route('pro2.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
    </a>

    {{-- Bảng sản phẩm --}}
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Loại</th>
                <th>Thương hiệu</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th class="text-center" style="width:150px;">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->category->catename }}</td>
                    <td>{{ $item->brand->brandname }}</td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td>
                        <img src="{{ asset('storage/products/' . $item->fileName) }}" alt="Ảnh sản phẩm" width="60">
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap justify-content-center">
                            {{-- Nút Sửa --}}
                            <a href="{{ route('pro2.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- Nút Xoá (dùng modal) --}}
                            <button type="button" class="btn btn-danger btn-sm btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDelete"
                                data-action="{{ route('pro2.delete', $item->id) }}"
                                data-info="{{ $item->productname }}"
                                title="Xoá">
                                <i class="bi bi-trash"></i>
                            </button>

                            {{-- (Tuỳ chọn) Nút xem chi tiết --}}
                            <button class="btn btn-secondary btn-sm"
                                data-bs-toggle="collapse"
                                data-bs-target="#r{{ $loop->index }}"
                                aria-expanded="false"
                                aria-controls="r{{ $loop->index }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Hàng ẩn để hiển thị thêm thông tin chi tiết sản phẩm --}}
                <tr id="r{{ $loop->index }}" class="collapse">
                    <td colspan="7">
                        <ul class="mb-0">
                            <li><strong>Mô tả:</strong> {{ $item->description ?? 'Chưa có' }}</li>
                            <li><strong>Số lượng tồn:</strong> {{ $item->stock ?? '0' }}</li>
                            {{-- Có thể thêm các thông tin khác nếu muốn --}}
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Phân trang + chọn số bản ghi --}}
    <div class="d-flex mt-3">
        <select class="form-select me-2" style="width:80px" onchange="window.location.href=this.value">
            <option value="{{ route('pro2.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
            <option value="{{ route('pro2.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
            <option value="{{ route('pro2.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
            <option value="{{ route('pro2.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
        </select>
        <label class="align-self-center">Số bản ghi / trang</label>

        <div class="ms-auto">
            {{ $list->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

{{-- Modal xác nhận xoá --}}
<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xoá</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xoá sản phẩm <strong id="deleteItemName"></strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script xử lý modal xoá --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('deleteForm');
    const deleteItemName = document.getElementById('deleteItemName');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            deleteForm.action = this.getAttribute('data-action');
            deleteItemName.textContent = this.getAttribute('data-info');
        });
    });
});
</script>
@endsection
