@extends('layout.admin')

@section('title', 'Loại sản phẩm - Cập nhật')

@section('content')
    <div class="container mt-5">
        <h3>Cập nhật loại sản phẩm</h3>
        <x-alert></x-alert>
        <div class="card shadow-sm mt-3" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST" action="{{ route('cate.update', $category->cateid) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="f-catename" class="form-label">Tên loại sản phẩm</label>
                        <input type="text" name="catename" class="form-control m-2" id="f-catename"
                            value="{{ old('catename', $category->catename) }}">
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Mã loại</label>
                        <input type="text" name="code" class="form-control"
                            value="{{ old('code', $category->code ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if (!empty($category->image))
                            <img src="{{ asset('storage/categories/' . $category->image) }}" width="100" class="mt-2">
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('cate.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
