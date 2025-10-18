@extends('layout.admin')

@section('title', 'Sản phẩm - Cập nhật')

@section('content')
<div class="container mt-4">
    <h2>Cập nhật sản phẩm</h2>

    <x-alert></x-alert>

    <form action="{{ route('pro2.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif

        <div class="mb-3">
            <label for="proname" class="form-label">Tên sản phẩm</label>
            <input type="text" name="proname" class="form-control"
                   value="{{ old('proname', $product->proname) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" name="price" class="form-control"
                   value="{{ old('price', $product->price) }}" required step="0.01" min="0">
        </div>

        <div class="mb-3">
            <label for="brandid" class="form-label">Thương hiệu</label>
            <select name="brandid" class="form-select" required>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->brandid == $brand->id ? 'selected' : '' }}>
                        {{ $brand->brandname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cateid" class="form-label">Loại sản phẩm</label>
            <select name="cateid" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->cateid }}"
                        {{ $product->cateid == $category->cateid ? 'selected' : '' }}>
                        {{ $category->catename }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ✅ Checkbox xác định sản phẩm có phiên bản --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="has_version" class="form-check-input" id="has_version"
                {{ old('has_version', $product->has_version ?? false) ? 'checked' : '' }}>
            <label for="has_version" class="form-check-label">
                Sản phẩm có nhiều phiên bản (dung lượng / cấu hình)?
            </label>
        </div>

        <div class="mb-3">
            <label for="f-des" class="form-label">Mô tả</label>
            <textarea name="description" id="f-des" rows="3" class="form-control">
                {{ old('description', $product->description) }}
            </textarea>
        </div>

        <div class="mb-3">
            <label for="f-path" class="form-label">Hình ảnh</label>
            <input type="file" name="fileName" id="f-path" class="form-control m-2" accept="image/*">
            <img src="{{ asset('storage/products/' . $product->fileName) }}" class="img-fluid m-2" width="100">
            @error('fileName')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <a href="{{ route('pro2.index') }}" class="btn btn-success">←</a>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
