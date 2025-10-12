@extends('layout.admin')

@section('title', 'Loại sản phẩm')

@section('content')
    <div class="container mt-4">
        <h3>Danh sách loại sản phẩm</h3>
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <a class="btn btn-primary mb-3" href="{{ route('cate.create') }}">+ Thêm</a>

        <div id="list">
            @include('admin.categories.list')
        </div>

    </div>
    {{-- <div class="modal fade" id="confirmdelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="info">....</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <x-modal></x-modal>
    <x-ajax-pagination></x-ajax-pagination>
@endsection
