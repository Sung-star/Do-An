@extends('layout.admin')

@section('title', 'Sửa khách hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-warning">✏️ Sửa thông tin khách hàng</h2>

    <form method="POST" action="{{ route('ad.customers.update', $customer) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">👤 Họ tên</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $customer->fullname) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">📞 Số điện thoại</label>
            <input type="text" name="tel" class="form-control" value="{{ old('tel', $customer->tel) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">🏠 Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('ad.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
