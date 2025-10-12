@extends('layout.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="container mt-5" style="max-width: 550px;">
        <div class="card shadow-lg p-4 rounded-4 bg-white">
            <h3 class="text-center mb-4 text-primary">🔐 Đổi mật khẩu</h3>

            {{-- Hiển thị thông báo --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <form action="{{ route('ad.changepass') }}" method="POST">
                @csrf

                {{-- Mật khẩu hiện tại --}}
                <div class="mb-3">
                    <label class="form-label">🔑 Mật khẩu hiện tại</label>
                    <div class="input-group">
                        <input type="password" name="current_password" class="form-control rounded-start password-input" required>
                        <span class="input-group-text toggle-password" style="cursor: pointer;">👁️</span>
                    </div>
                    @error('current_password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mật khẩu mới --}}
                <div class="mb-3">
                    <label class="form-label">🔏 Mật khẩu mới</label>
                    <div class="input-group">
                        <input type="password" name="new_password" class="form-control rounded-start password-input" required>
                        <span class="input-group-text toggle-password" style="cursor: pointer;">👁️</span>
                    </div>
                    @error('new_password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Xác nhận mật khẩu mới --}}
                <div class="mb-4">
                    <label class="form-label">🔁 Xác nhận mật khẩu mới</label>
                    <div class="input-group">
                        <input type="password" name="new_password_confirmation" class="form-control rounded-start password-input" required>
                        <span class="input-group-text toggle-password" style="cursor: pointer;">👁️</span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3">✅ Cập nhật mật khẩu</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS toggle --}}
    @push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach((eye) => {
            eye.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input');
                if (input.type === "password") {
                    input.type = "text";
                    this.textContent = "🙈";
                } else {
                    input.type = "password";
                    this.textContent = "👁️";
                }
            });
        });
    </script>
    @endpush
@endsection
