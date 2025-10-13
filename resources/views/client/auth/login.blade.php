@extends('layout.client')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <h4>Đăng nhập</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="auth-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email"
                       class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" name="password"
                       class="form-control" required>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember"
                       class="form-check-input" id="remember">
                <label for="remember" class="form-check-label">
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn auth-btn w-100">Đăng nhập</button>

            <a href="{{ url('/register') }}" class="auth-link">
                Chưa có tài khoản? Đăng ký
            </a>
        </form>
    </div>
</div>
@endsection
