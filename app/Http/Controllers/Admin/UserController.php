<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        // hiển thị danh sách người dùng
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    public function login()
    {
        // hiển thị trang đăng nhập
        return view('admin.users.login');
    }
    public function loginpost(Request $request)
    {

        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        $user = User::where('email', $request->email)->first();
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            // điều hướng về view login theo route name (đặt trong web.php)
            return redirect()->route('ad.login')->with('message', 'Email không tồn tại')->withInput();
        }
        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // do mật khẩu dùng Hash::make() để mã hóa, nên cần so sánh phải dùng với hàm Hash::check()
        $check = Hash::check($request->password, $user->password); // true hoặc false
        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về view login theo route name (đặt trong web.php)
            return redirect()->route('ad.login')->with('message', 'Mật khẩu không đúng')->withInput();
        }
        // Nếu thông tin đăng nhập đúng thì lưu thông tin người dùng vào session với Auth::login($user)
        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        // nếu không có thì điều hướng về dasboard (route name dashboard được khai báo trong web.php)
        return redirect()->intended(route('ad.dashboard'));
    }
    public function logout(Request $request)
    {
        // xử lý đăng xuất
        // chức năng chỉ được sử dụng sau khi đăng nhập thành công
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('ad.login')->with('message', 'Đăng xuất thành công');
    }

    public function changepass(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }

    public function showChangePassForm()
    {
        return view('admin.users.changepass'); // đường dẫn view đổi mật khẩu
    }

    public function forgotpassform()
    {
        return view('admin.users.forgotpassform');
    }

    public function forgotpass(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('ad.forgotpass')
                ->with('message', 'Email không tồn tại trong hệ thống.')
                ->withInput();
        }

        $passrandom = Str::random(10); // Tạo mật khẩu ngẫu nhiên
        $passencrypte = Hash::make($passrandom); // Mã hóa mật khẩu
        User::where('email', $request->email)
            ->update(['password' => $passencrypte]);
        $html = "<h2>Mật khẩu mới của bạn là: $passrandom. Vui lòng đổi mật khẩu sau khi nhận được mật khẩu mới</h2>";
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
        });

        return redirect()->route('ad.forgotpass')
            ->with('message', 'Mật khẩu mới đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư đến.');
    }
}
