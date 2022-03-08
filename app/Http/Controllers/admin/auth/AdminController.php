<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        $numb = $request['phone'];
        $admin = Admin::where('phone', $request->phone)->first();
        if (isset($admin)) {
            Toastr::warning('Nomer Handphone sudah dipakai');

            return redirect()->back();
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'unique:admins|min:9',
            'password' => 'required|min:8|same:c_password',
        ]);

        $admin = Admin::create([
            'name' => $request['name'],
            'phone' => $numb,
            'role' => $request['role'],
            'password' => bcrypt($request['password']),
        ]);

        Toastr::success('Admin successfully created');

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user = Admin::find($request['id']);

        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->role = $request['role'];
        $user->save();
        Toastr::success('Admin berhasil diubah');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        // dd($request);
        $data = Admin::where('id', $request['id'])->first();
        $data->delete();
        Toastr::info('Admin berhasil dihapus!');

        return redirect()->back();
    }
}
