@extends('layout.admin')

@section('title', 'Người dùng - Thêm')

@section('content')
    <div class="container mt-4">
        <h3>Thêm người dùng</h3>
        <div class="card shadow-sm mt-3" style="max-width: 600px;">
            <div class="card-body">

                <div class="mb-3">
                    <label for="name" class="form-label">Tên người dùng</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Nhập lại mật khẩu">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    <select class="form-select" id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="staff">Nhân viên</option>
                        <option value="customer">Khách hàng</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" onclick="history.back()" class="btn btn-success">←</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>

            </div>
        </div>
    </div>

@endsection
