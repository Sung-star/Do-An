<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>STT</th>
            <th>Tên loại</th>
            <th>Mô tả</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->catename }} ({{ $item->products->count() }} sản phẩm)</td>
                <td>{{ $item->description }}</td>
                <td>
                    <div class="d-flex gap-1 flex-wrap">
                        {{-- Nút Sửa --}}
                        <a href="{{ route('cate2.edit', $item->cateid) }}" class="btn btn-warning btn-sm" title="Sửa">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Nút Xoá --}}
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                            data-bs-target="#confirmdelete" data-action="{{ route('cate2.delete', $item->cateid) }}"
                            data-info="{{ $item->catename }}" title="Xoá">
                            <i class="bi bi-trash"></i>
                        </button>

                        {{-- Nút xổ sản phẩm --}}
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="collapse"
                            data-bs-target="#r{{ $loop->index }}" aria-expanded="false"
                            aria-controls="r{{ $loop->index }}">
                            <i class="bi bi-eye"></i> Xem sản phẩm
                        </button>
                    </div>
                </td>
            </tr>

            <tr id="r{{ $loop->index }}" class="collapse">
                <td colspan="5">
                    <ul class="mb-0">
                        @forelse ($item->products as $pro)
                            <li>{{ $pro->proname }}</li>
                        @empty
                            <li><em>Không có sản phẩm nào</em></li>
                        @endforelse
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $list->links('pagination::bootstrap-4') }}
