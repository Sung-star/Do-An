@extends('layout.admin')

@section('title', 'Loại sản phẩm - Thêm')

@section('content')
    <div class="container mt-5">
        <h3>Thêm loại sản phẩm</h3>
        <x-alert></x-alert>
        <div class="card shadow-sm mt-3" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST" action="{{ route('cate.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="f-catename" class="form-label">Tên loại sản phẩm</label>
                        <input type="text" name="catename" class="form-control m-2" id="f-catename"
                            placeholder="Nhập tên loại" value="{{ old('catename') }}">
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Mã loại</label>
                        <input type="text" name="code" class="form-control"
                            value="{{ old('code') }}">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('cate.index') }}" class="btn btn-success">←</a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
