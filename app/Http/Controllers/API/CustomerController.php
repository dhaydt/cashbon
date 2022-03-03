<?php

namespace App\Http\Controllers\API;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Cashbon;
use App\Models\Customer;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function pengajuan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengajuan' => 'required',
            'keperluan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $order = new Cashbon();
        $order->pekerja_id = $request->user()->id;
        $order->project_id = $request->project_id;
        $order->pengajuan = $request->pengajuan;
        $order->keperluan = $request->keperluan;
        $order->diajukan_pada = Carbon::now();
        $order->approver = json_encode([]);
        $order->approver_status = json_encode([]);
        $order->admin_status = 'menunggu';
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil, mohon tunggu informasi selanjutnya',
        ]);
    }
}
