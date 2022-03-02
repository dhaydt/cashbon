<?php

namespace App\Http\Controllers\customers\auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function index()
    {
        return view('customers.auth.register');
    }

    public function submit(Request $request)
    {
        // dd($request);
        $numb = strval((int) $request['phone']);
        $user = Customer::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        // Verify Token
        // if (isset($user) && $user->is_phone_verified == 0 && $user->is_email_verified == 0) {
        //     return redirect(route('customer.auth.check', [$user->id]));
        // }

        if (isset($user)) {
            Toastr::warning('Email atau nomor telepon sudah terdaftar');

            return redirect()->back();
        }

        // dd($request);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'unique:customers',
            'password' => 'required|min:8|same:password_confirmation',
        ]);

        $user = Customer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $numb,
            'image' => 'profile.png',
            'is_active' => 1,
            'password' => bcrypt($request['password']),
        ]);

        Toastr::success('Pendaftaran berhasil, Silahkan Login');

        return redirect(route('customersLogin'));
    }
}
