@extends('layout.admin')

@section('title', 'Danh sách khách hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-primary">📋 Danh sách khách hàng</h2>

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Nút thêm --}}
    <div class="mb-3 text-end">
        <a href="{{ route('ad.customers.create') }}" class="btn btn-success">➕ Thêm khách hàng</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>👤 Họ tên</th>
                    <th>📞 SĐT</th>
                    <th>📧 Email</th>
                    <th>🏠 Địa chỉ</th>
                    <th>🛒 Đơn hàng</th>
                    <th>⚙️ Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->fullname }}</td>
                        <td>{{ $customer->tel }}</td>
                        <td>{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->address }}</td>
                        <td><span class="badge bg-success">{{ $customer->orders_count }}</span></td>
                        <td>
                            <a href="{{ route('ad.customers.edit', $customer) }}" class="btn btn-sm btn-warning">✏️ Sửa</a>
                            <form action="{{ route('ad.customers.destroy', $customer) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?')" class="btn btn-sm btn-danger">
                                    🗑️ Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"><em>Không có khách hàng nào.</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
