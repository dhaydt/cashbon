<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Cashbon;
use Brian2694\Toastr\Facades\Toastr;
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
        $status = [];
        foreach ($request['approver'] as $ap) {
            $a = [
                'id' => $ap,
                'status' => 'menunggu',
                'accepted' => 0,
            ];
            array_push($status, $a);
        }
        $data = Cashbon::find($request['cashbon_id']);
        $data->approver = json_encode($request['approver']);
        $data->approver_status = json_encode($status);
        $data->admin_status = 'diproses';
        $data->save();
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
