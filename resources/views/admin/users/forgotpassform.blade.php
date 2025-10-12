<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>

    <!-- Google Fonts + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .forgot-box {
            background-color: #ffffffdd;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
            width: 100%;
            max-width: 450px;
        }

        h2 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            transition: box-shadow 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 8px #f9a825;
            border-color: #f9a825;
        }

        .btn-primary {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .btn-primary:hover {
            transform: scale(1.03);
        }

        a {
            display: inline-block;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #333;
        }

        a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>
    <form action="{{ route('ad.forgotpasspost') }}" method="POST" class="forgot-box">
        @csrf
        <h2 class="text-center">🔑 Quên mật khẩu</h2>

        <x-alert></x-alert>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <label for="email" class="form-label">📧 Email</label>
            <input type="email" name="email" id="email" class="form-control"
                placeholder="Nhập email đăng ký" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Tiếp tục</button>

        <div class="text-end mt-3">
            <a href="{{ route('ad.login') }}">← Quay lại đăng nhập</a>
        </div>
    </form>
</body>

</html>
