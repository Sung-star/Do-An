<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>STT</th>
            {{-- <th>Mã thương hiệu</th> --}}
            <th>Tên thương hiệu</th>
            <th>Mô tả</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- <td>{{ $item->code ?? 'không có mã' }}</td> --}}
                <td>{{ $item->brandname }}</td>
                <td>{{ $item->description ?? '-' }}</td>
                <td>
                    <div class="d-flex">
                        {{-- Nút Sửa --}}
                        <a href="{{ route('brand2.edit', $item->id) }}" 
                           class="btn btn-warning btn-sm mx-1" title="Sửa">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Nút Xóa (SweetAlert2) --}}
                        <button type="button" 
                                class="btn btn-danger btn-sm mx-1 btn-delete"
                                data-action="{{ route('brand2.delete', $item->id) }}"
                                data-info="{{ $item->brandname }}"
                                title="Xóa">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $list->links('pagination::bootstrap-4') }}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const actionUrl = btn.dataset.action;
            const brandName = btn.dataset.info;

            Swal.fire({
                title: 'Xác nhận xóa?',
                text: `Bạn có chắc muốn xóa thương hiệu "${brandName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then(result => {
                if (result.isConfirmed) {
                    // Tạo form ẩn để submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;

                    // CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = token;
                    form.appendChild(csrfInput);

                    // Phương thức DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
