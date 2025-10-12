<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>

    <!-- Google Fonts + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #ffffffdd;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 30px 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
        }

        .login-box h2 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            transition: box-shadow 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 8px #87CEFA;
            border-color: #87CEFA;
        }

        .btn-primary {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .btn-primary:hover {
            transform: scale(1.03);
        }

        .alert {
            border-radius: 10px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #333;
            text-align: center;
            width: 100%;
        }

        a:hover {
            color: #007bff;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 1.3rem;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .input-group-text {
            border-left: none;
        }
    </style>
</head>

<body>
    <form action="{{ route('ad.loginpost') }}" method="POST" class="login-box">
        @csrf
        <h2 class="text-center">🔐 Đăng nhập hệ thống</h2>

        <x-alert></x-alert>

        {{-- Email --}}
        <div class="mb-3">
            <label for="f-username" class="form-label">📧 Email</label>
            <input type="text" class="form-control" id="f-username" name="email" placeholder="Nhập email"
                value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mật khẩu với icon 👁️ --}}
        <div class="mb-3">
            <label for="f-password" class="form-label">🔒 Mật khẩu</label>
            <div class="input-group">
                <input type="password" class="form-control password-input" id="f-password" name="password" placeholder="Nhập mật khẩu">
                <span class="input-group-text toggle-password">👁️</span>
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember --}}
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">
                Ghi nhớ đăng nhập
            </label>
        </div>

        {{-- Nút submit --}}
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

        {{-- Quên mật khẩu --}}
        <a href="{{ route('ad.forgotpass') }}">Quên mật khẩu?</a>
    </form>

    {{-- Toggle password JS --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach((eye) => {
            eye.addEventListener('click', function () {
                const input = this.parentElement.querySelector('.password-input');
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
</body>

</html>
