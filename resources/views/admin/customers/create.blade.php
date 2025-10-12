@extends('layout.admin')

@section('title', 'Thêm khách hàng')

@section('content')
<div class="container">
    <h2 class="my-4 text-success">➕ Thêm khách hàng</h2>

    <form method="POST" action="{{ route('ad.customers.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">👤 Họ tên</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">📞 Số điện thoại</label>
            <input type="text" name="tel" class="form-control" value="{{ old('tel') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">🏠 Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="{{ route('ad.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
