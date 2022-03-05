<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Cashbon;
use App\Models\Customer;
use App\Models\Project;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashbonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $admin = Cashbon::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('admin_status', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $admin = Cashbon::with('pekerja', 'project');
        }

        session()->put('title', 'Pengajuan Kasbon');
        $admin = $admin->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        // $worker = Customer::get();
        // $app = Approver::get();

        return view('admin-views.cashbon.list', compact('admin', 'search'));
    }

    public function addApprover(Request $request)
    {
        // dd($request);
        $status = [];
        foreach ($request['approver'] as $ap) {
            $a = [
                'id' => $ap,
                'status' => 'menunggu',
                'accepted' => 0,
            ];
            array_push($status, $a);
        }
        $data = Cashbon::with('pekerja', 'project')->find($request['cashbon_id']);
        $data->approver = json_encode($request['approver']);
        $data->approver_status = json_encode($status);
        $data->admin_status = 'diproses';
        // $data->save();
        foreach ($request['approver'] as $app) {
            $approver = Approver::find($app);
            $fcm_token = $approver->device_token;
            $data = [
                'project' => $data->project->name,
                'pekerjaan' => $data->keperluan,
                'status' => 'diproses',
                'dipinjamkan' => $data->pengajuan,
            ];
            Helpers::send_push_notif_to_device($fcm_token, $data);
        }

        Toastr::success('Approver berhasil ditambahkan');

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = Cashbon::with('pekerja', 'project')->find($request['id']);

        return view('admin-views.cashbon.view.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cash = Cashbon::find($request['cashbon_id']);
        $cash->admin_status = $request['status'];
        $cash->dipinjamkan = $request['nilai'];
        $cash->type = $request['type'];
        $cash->no_nota = $request['nota'];
        $cash->diterima_pada = Carbon::now();
        $cash->save();
        // dd($cash);

        // Total Cashbon
        $total = Cashbon::where('project_id', $cash->project_id)->pluck('dipinjamkan')->toArray();
        $sum = array_sum($total);
        $project = Project::find($cash->project_id);
        $sisa = $project->nilai_project - $sum;
        $project->total_cashbon = $sum;
        $project->sisa = $sisa;
        $project->save();
        $data = [
            'project' => $project->name,
            'pekerjaan' => $cash->keperluan,
            'status' => $cash->admin_status,
            'dipinjamkan' => $cash->dipinjamkan,
        ];

        $worker = Customer::where('id', $cash->pekerja_id)->first();
        $fcm_token = $worker->device_token;
        // dd($fcm_token);
        Helpers::send_push_notif_to_device($fcm_token, $data);

        Toastr::success('Approver berhasil '.$request['status']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Cashbon::where('id', $request['id'])->first();
        if ($data == null) {
            Toastr::info('Kasbon berhasil dihapus!');

            return redirect()->back();
        }
        $data->delete();
        Toastr::info('Kasbon berhasil dihapus!');

        return redirect()->back();
    }
}
