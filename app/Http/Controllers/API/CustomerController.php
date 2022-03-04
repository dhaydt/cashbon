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
    public function login($cred)
    {
        // dd('worker', $cred);

        $customer = Customer::where('phone', $cred['phone'])->first();

        if (!$customer) {
            return response()->json(['errors' => 'No Handphone tidak terdaftar'], 403);
        }

        if (!Hash::check($cred['password'], $customer->password)) {
            return response()->json(['errors' => 'Password salah'], 403);
        }

        $id = $customer->id;
        $pekerja = Project::whereJsonContains('pekerja', ['id' => (string) $id])->get(['id', 'name']);

        $data = $customer->where('phone', $cred['phone'])->get(['id', 'name', 'phone', 'cashbon']);

        return response()->json([
            'role' => 'worker',
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

    public function status(Request $request)
    {
        $casbon = Cashbon::with('pekerja', 'project')->where('pekerja_id', $request['id'])->get();
        $data = [];
        foreach ($casbon as $c) {
            $item = [
                'project' => $c->project->name,
                'jumlah_pengajuan' => $c->pengajuan,
                'pekerjaan' => $c->keperluan,
                'tgl_diajukan' => $c->diajukan_pada,
                'status' => $c->admin_status,
                'jumlah_disetujui' => $c->dipinjamkan,
                'tgl_disetujui' => $c->diterima_pada,
                // 'no_nota' => $c->no_nota,
            ];
            array_push($data, $item);
        }

        return response()->json($data);
    }
}
