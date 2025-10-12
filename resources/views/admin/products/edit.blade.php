@extends('layout.admin')

@section('title', 'Sản phẩm - Cập nhật')

@section('content')
    <div class="container mt-4">
        <h2>Cập nhật sản phẩm</h2>

        <x-alert></x-alert>

        <form action="{{ route('pro.update', $product->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="proname" class="form-label">Tên sản phẩm</label>
                <input type="text" name="proname" class="form-control" value="{{ old('proname', $product->proname) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}"
                    required step="0.01" min="0">
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

            <div class="mb-3">
                <label for="f-des" class="form-label">Mô tả</label>
                <textarea name="description" id="f-des" rows="5" class="form-control"> {{ old('description', $product->description) }}</textarea>
            </div>

            <a href="{{ route('pro.index') }}" class="btn btn-success">←</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
