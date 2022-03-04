<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Cashbon;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApproverController extends Controller
{
    public function login($cred)
    {
        // dd('approver', $cred);

        $driver = Approver::where('phone', $cred['phone'])->first();

        if (!$driver || !Hash::check($cred['password'], $driver->password)) {
            return response()->json(['errors' => 'No Handphone atau Password salah'], 403);
        }

        $id = $driver->id;
        $project = Project::whereJsonContains('approver', ['id' => (string) $id])->get(['id', 'name']);

        $data = $driver->where('phone', $cred['phone'])->get(['id', 'name', 'phone']);

        $persetujuan = Cashbon::with('pekerja', 'project')->whereJsonContains('approver_status', ['id' => (string) $id])->get();

        $cashbon = [];
        foreach ($persetujuan as $p) {
            $peng = [
                'cashbon_id' => $p->id,
                'pekerja_id' => $p->pekerja_id,
                'name' => $p->pekerja->name,
                'project_id' => $p->project_id,
                'project_name' => $p->project->name,
                'pengajuan' => $p->pengajuan,
                'keperluan' => $p->keperluan,
                'diajukan_pada' => $p->diajukan_pada,
            ];
            array_push($cashbon, $peng);
        }
        // dd($cashbon);

        return response()->json([
            'role' => 'approver',
            'user_data' => $data,
            'pengajuan' => $cashbon,
            'project' => $project,
            'token' => $driver->createToken('mobile', ['role:approver'])->plainTextToken,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $cashbon = Cashbon::find($request['cashbon_id']);
        $id = $request->user()->id;
        $status = json_decode($cashbon->approver_status);
        $newStatus = [];
        foreach ($status as $s) {
            if ($s->id == $id) {
                $new = [
                    'id' => $id,
                    'status' => $request['status'],
                    'accepted' => $request['nilai'],
                    'diupdate_pada' => Carbon::now(),
                ];
                array_push($newStatus, $new);
            } else {
                array_push($newStatus, $s);
            }
        }
        $cashbon->approver_status = $newStatus;
        $cashbon->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data persetujuan berhasil dikirim',
        ]);
    }
}
