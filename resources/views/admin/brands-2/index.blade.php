@extends('layout.admin')

@section('title', 'Thương hiệu')

@section('content')
    <div class="container mt-4">
        <h3>Thương hiệu (Eloquent ORM)</h3>
        <a class="btn btn-primary mb-3" href="{{ route('brand2.create') }}">+ Thêm</a>
        <x-alert></x-alert>
        <div id="list">
            @include('admin.brands-2.list')
        </div>
    </div>
    ...
@endsection
