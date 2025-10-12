<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tên loại</th>
            <th>Mã loại</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/categories/' . $item->image) }}" width="60">
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </td>
                <td>{{ $item->catename }}</td>
                <td>{{ $item->code ?? '-' }}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('cate.edit', $item->cateid) }}" class="btn btn-warning mx-1">Sửa</a>
                        <form action="{{ route('cate.delete', $item->cateid) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger mx-1">Xóa</button>
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#confirmdelete" data-info="{{ $item->catename }}"
                            data-action="{{ route('cate.delete', $item->cateid) }}">
                            Xóa (modal)
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $list->links('pagination::bootstrap-4') }}
