@extends('layout.admin')

@section('title', 'Danh sách người dùng')
@section('content')
    <div class="container mt-4">
        <h2>Danh sách người dùng</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Chưa có' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Không có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
