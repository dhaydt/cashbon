<?php

namespace App\Http\Controllers\customers\auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Env;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function index()
    {
        return view('customers.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $remember = ($request['remember']) ? true : false;
        $user = Customer::where('email', $request->email)->first();

        if (isset($user) == false) {
            Toastr::error('Email belum terdaftar');

            return back()->withInput();
        }
        // dd($user, bcrypt($request->password));

        if (isset($user) && $user->is_active && auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            Toastr::info('Welcome  '.$user->name.'to '.env('APP_NAME', 'Backend').' !');

            return view('welcome');
        }
        // dd($user);

        Toastr::error('Password atau email salah');

        return back()->withInput();
    }

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        // session()->forget('wish_list');
        Toastr::info('Come back soon, '.'!');

        // session()->put('hide_banner', false);

        return redirect('/');
    }
}
