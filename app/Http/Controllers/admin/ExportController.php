<?php

namespace App\Http\Controllers\admin;

use App\Exports\cashbonExport;
use App\Http\Controllers\Controller;
use App\Models\Cashbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start = $request['start-date'];
        $end = $request['end-date'];

        if ($start == $end) {
            $orders = Cashbon::where('admin_status', 'diterima')->where('created_at', 'like', "%{$start}%")->with('pekerja', 'project', 'approver')->get();
        } else {
            $orders = Cashbon::where('admin_status', 'diterima')->whereBetween('created_at', [$start, $end])->with('pekerja', 'project', 'approver')->get();
        }

        $data = [];

        $orders->map(function ($order, $i) use ($data) {
            return [
                'tgl_terima' => $order->diterima_pada,
                'nama' => $order->pekerja->name,
                'nilai_project' => $order->project->nilai_project,
                'total_kasbon' => $order->project->total_cashbon,
                'sisa' => $order->project->sisa,
                'Tipe' => $order->type,
                'Nota' => $order->no_nota,
                'nama_project' => $order->project->name,
                'deskripsi' => $order->keperluan,
                'jumlah' => '',
            ];
        });

        foreach ($orders as $o) {
            $item = [
                'tgl_terima' => date('d-M-Y', strtotime($o->diterima_pada)),
                'nama' => $o->pekerja->name,
                'nilai_project' => $o->project->nilai_project,
                'total_kasbon' => $o->project->total_cashbon,
                'sisa' => $o->project->sisa,
                'Tipe' => $o->type,
                'Nota' => $o->no_nota,
                'nama_project' => $o->project->name,
                'deskripsi' => $o->keperluan,
                'jumlah' => '',
            ];
            array_push($data, $item);
        }

        return Excel::download(new cashbonExport($data), 'Laporan kasbon | '.$start.' -- '.$end.'.xlsx');
    }
}
