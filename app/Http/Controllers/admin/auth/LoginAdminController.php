<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function loginAdmin()
    {
        return view('admin-views.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        $user_id = $request->phone;
        if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
            $medium = 'email';
        } else {
            $count = strlen(preg_replace("/[^\d]/", '', $user_id));
            if ($count >= 9 && $count <= 15) {
                $medium = 'phone';
            } else {
                Toastr::error('Invalid user email or phone number.');
            }
        }

        if ($medium == 'email') {
            if (auth('admin')->attempt(['email' => $request->phone, 'password' => $request->password], $request->remember)) {
                return redirect()->route('admin.dashboard');
            }
        }
        if ($medium == 'phone') {
            if (auth('admin')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->remember)) {
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->back()->withInput($request->only('phone', 'remember'))->withErrors(['Password atau email salah.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        return redirect()->route('home');
    }
}
