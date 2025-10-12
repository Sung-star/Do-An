@extends('layout.admin')

@section('title', 'Thương hiệu - Thêm')

@section('content')
    <div class="container mt-5">
        <h3>Thêm thương hiệu</h3>
        <x-alert></x-alert>
        <div class="card shadow-sm mt-3" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST" action="{{ route('brand.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="f-brandname" class="form-label">Tên thương hiệu</label>
                        <input type="text" name="brandname" class="form-control m-2" id="f-brandname"
                            placeholder="Nhập tên thương hiệu" value="{{ old('brandname') }}">
                        @error('brandname')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Mã thương hiệu</label>
                        <input type="text" name="code" class="form-control"
                            value="{{ old('code', $brand->code ?? '') }}">
                        @error('code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        @if (!empty($brand->image))
                            <img src="{{ asset('storage/' . $brand->image) }}" width="100" class="mt-2">
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('brand.index') }}" class="btn btn-success">←</a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
