@extends('layout.client')

@section('content')
    <style>
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 85vh;
            background: linear-gradient(135deg, #f8fbff 0%, #eef2ff 100%);
            transition: background 0.4s ease;
        }

        body[data-theme="dark"] .auth-wrapper {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        /* 🔹 FORM CARD */
        .auth-card {
            background-color: var(--bg-light);
            color: var(--text-dark);
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            animation: fadeIn 0.5s ease;
        }

        body[data-theme="dark"] .auth-card {
            background-color: #1e293b;
            color: #f8fafc;
            box-shadow: 0 6px 25px rgba(255, 255, 255, 0.08);
        }


        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        }

        /* ✅ Dark mode input fix */
        body[data-theme="dark"] .form-control {
            background-color: #0f172a;
            color: #f1f5f9;
            border: 1px solid #334155;
        }

        body[data-theme="dark"] .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.3);
        }

        body[data-theme="dark"] .form-label {
            color: #e2e8f0;
        }

        /* 🔹 HEADINGS */
        .auth-card h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* 🔹 BUTTON */
        .auth-btn {
            background: #28a745;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            transition: all .3s ease;
        }

        .auth-btn:hover {
            background: #1e7e34;
            transform: scale(1.03);
        }

        /* 🔹 LINK */
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

        /* 🔹 ANIMATION */
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

        /* 🧩 Force priority cho register (fix không ăn màu do Bootstrap override) */
        body[data-theme="dark"] .auth-card input.form-control,
        body[data-theme="light"] .auth-card input.form-control {
            background-color: inherit !important;
            color: inherit !important;
        }
    </style>


    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Đăng ký tài khoản</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>

                <button type="submit" class="btn auth-btn w-100">Đăng ký</button>

                <a href="{{ url('/login') }}" class="auth-link">
                    Đã có tài khoản? Đăng nhập
                </a>
            </form>
        </div>
    </div>
@endsection
