<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();
        if (!$customer) {
            return response()->json(['errors' => 'No Handphone tidak terdaftar'], 403);
        }

        if (!Hash::check($request->password, $customer->password)) {
            return response()->json(['errors' => 'Password salah'], 403);
        }

        $id = $customer->id;
        $pekerja = Project::whereJsonContains('pekerja', ['id' => (string) $id])->get(['id', 'name']);

        $data = $customer->where('phone', $request->phone)->get(['id', 'name', 'phone', 'cashbon']);

        return response()->json([
            'role' => 'pekerja',
            'user_data' => $data,
            'project' => $pekerja,
            'token' => $customer->createToken('mobile', ['role:customer'])->plainTextToken,
        ]);
    }
}
