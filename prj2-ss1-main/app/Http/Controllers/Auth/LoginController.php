<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

// GET: /admin/login
    function viewLoginForm()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('aa-home');
        }
        return view('auth.login');
    }

    // POST: /admin/login
    function login(Request $request)
    {
        // Bước 1: Lấy dữ liệu từ
        $email = $request->input('email');
        $password = $request->input('password');

        // Bước 2: Đăng nhập
        if (Auth::guard('user')->attempt([
            'email' => $email,
            'password' => $password
        ])) {
            // Chuyển hướng
//            $request->session()->regenerate();
            // Chuyển hướng về home admin
            return redirect()->route('aa-home');

        } else {
            // Tro ve login -> su dung return back
            flash()->addError('Đăng nhập thất bại!');
            return redirect()->back();
        }
    }

    // POST: /admin/logout
    function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('login');
    }
}
