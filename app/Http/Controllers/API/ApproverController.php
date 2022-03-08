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
        $project = Cashbon::with('pekerja', 'project')->whereJsonContains('approver', (string) $id)->orderBy('created_at', 'DESC')->pluck('project_id', 'project_id')->toArray();

        $data = $driver->where('phone', $cred['phone'])->get(['id', 'name', 'phone']);

        $persetujuan = Cashbon::with('pekerja', 'project')->whereJsonContains('approver_status', ['status' => 'menunggu'])->whereJsonContains('approver', (string) $id)->orderby('created_at', 'DESC')->get();

        $cashbon = [];
        foreach ($persetujuan as $p) {
            $peng = [
                'cashbon_id' => $p->id,
                'tgl_pengajuan' => $p->diajukan_pada,
                'nama_pemohon' => $p->pekerja->name,
                'nama_project' => $p->project->name,
                'pekerjaan' => $p->keperluan,
                'nilai_kontrak' => $p->project->nilai_project,
                'total_kasbon' => $p->project->total_cashbon,
                'sisa_kasbon' => $p->project->sisa,
                'pengajuan_kasbon' => $p->pengajuan,
                'status' => $p->admin_status,
                'jumlah_kasbon_disetujui' => $p->dipinjamkan,
            ];
            array_push($cashbon, $peng);
        }

        $projects = [];
        foreach ($project as $pro) {
            $approv = Project::where('id', $pro)->first(['id', 'name']);
            array_push($projects, $approv);
        }
        // dd($projects);

        return response()->json([
            'role' => 'approver',
            'user_data' => $data,
            'pengajuan' => $cashbon,
            'project' => $projects,
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

    public function history(Request $request)
    {
        $id = $request->user()->id;
        $cash = Cashbon::with('pekerja', 'project')->whereJsonContains('approver', (string) ($id))->where('diterima_pada', '!=', 'NULL')->orderBy('created_at', 'DESC')->get();
        $cashbon = [];
        foreach ($cash as $p) {
            $peng = [
                'cashbon_id' => $p->id,
                'tgl_pengajuan' => $p->diajukan_pada,
                'nama_pemohon' => $p->pekerja->name,
                'nama_project' => $p->project->name,
                'pekerjaan' => $p->keperluan,
                'nilai_kontrak' => $p->project->nilai_project,
                'total_kasbon' => $p->project->total_cashbon,
                'sisa_kasbon' => $p->project->sisa,
                'pengajuan_kasbon' => $p->pengajuan,
                'status' => $p->admin_status,
                'diterima_pada' => $p->diterima_pada,
                'jumlah_kasbon_disetujui' => $p->dipinjamkan,
            ];
            array_push($cashbon, $peng);
        }

        return response()->json([
            'status' => 'success',
            'response' => $cashbon,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $id = $request->user()->id;
        $user = Approver::find($id);
        $old = $request->old_password;

        if (!$user || !Hash::check($old, $user['password'])) {
            return response()->json(['errors' => 'No Handphone atau Password salah'], 403);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password approver berhasil diganti'], 200);
    }
}
