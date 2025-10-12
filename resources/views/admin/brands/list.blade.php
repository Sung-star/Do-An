<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Mã thương hiệu</th>
            <th>Tên thương hiệu</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/brands/' . $item->image) }}" alt="Brand Image" width="60" height="60">
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </td>
                <td>{{ $item->code ?? 'không có mã loại thương hiệu' }}</td>
                <td>{{ $item->brandname }}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('brand.edit', $item->id) }}" class="btn btn-warning mx-1">Sửa</a>
                        <form action="{{ route('brand.delete', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger mx-1">Xóa</button>
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#confirmdelete"
                                data-info="{{ $item->brandname }}"
                                data-action="{{ route('brand.delete', $item->id) }}">
                            Xóa (modal)
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $list->links('pagination::bootstrap-4') }}
