@extends('layout.client')

@section('content')
    <style>
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            transition: background 0.4s ease;
        }

        /* ✅ Fix: dark mode theo data-theme của body */
        body[data-theme="dark"] .auth-wrapper {
            background: linear-gradient(135deg, #1e1e2e 0%, #121212 100%);
        }

        .auth-card {
            background-color: var(--bg-light);
            color: var(--text-dark);
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.5s ease;
        }

        /* Dark mode card */
        body[data-theme="dark"] .auth-card {
            background-color: #1e293b;
            color: #f8fafc;
            box-shadow: 0 6px 25px rgba(255, 255, 255, 0.08);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card h4 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .auth-btn {
            background: #007bff;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            transition: all .3s ease;
        }

        .auth-btn:hover {
            background: #0056b3;
            transform: scale(1.03);
        }

        .auth-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            text-decoration: none;
            color: #0d6efd;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        /* ========================= FIX TOÀN BỘ MÀU FORM ========================= */

        /* 🧊 Light mode form */
        .auth-card .form-control {
            background-color: #fff !important;
            color: #111 !important;
            border: 1px solid #ccc !important;
            border-radius: 10px !important;
            padding: 0.6rem 0.9rem !important;
            margin-top: 0.3rem !important;
            transition: all 0.25s ease;
        }

        .auth-card .form-control:focus {
            border-color: #007bff !important;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25) !important;
        }

        .auth-card .form-label {
            font-weight: 500;
            color: #333;
        }

        /* 🌙 Dark mode override (ưu tiên cao hơn Bootstrap) */
        body[data-theme="dark"] .auth-card .form-control {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
            border: 1px solid #334155 !important;
        }

        body[data-theme="dark"] .auth-card .form-control:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.4) !important;
        }

        body[data-theme="dark"] .auth-card .form-label {
            color: #e2e8f0 !important;
        }

        body[data-theme="dark"] .auth-card .auth-btn {
            background: #2563eb !important;
        }

        body[data-theme="dark"] .auth-card .auth-btn:hover {
            background: #1e40af !important;
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h4>Đăng nhập</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn auth-btn w-100">Đăng nhập</button>

                <a href="{{ url('/register') }}" class="auth-link">
                    Chưa có tài khoản? Đăng ký
                </a>
            </form>
        </div>
    </div>
@endsection
