<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Project;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ApproverController extends Controller
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
            $admin = Approver::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('project', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $admin = new Approver();
        }

        session()->put('title', 'Daftar Approver');
        $admin = $admin->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        $pro = Project::orderBy('created_at', 'DESC')->get();

        return view('admin-views.approver.list', compact('admin', 'search', 'pro'));
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
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'project' => 'required',
        ], [
            'name.required' => 'Nama pekerja dibutuhkan!',
            'phone.required' => 'Hp pekerja dibutuhkan!',
            'project.required' => 'Proyek pekerja dibutuhkan!',
        ]);

        $check = Approver::where('phone', $request['phone'])->first();
        if (isset($check)) {
            Toastr::error('No Handphone sudah digunakan!');

            return redirect()->route('admin.approver.list');
        }

        $data = new Approver();
        $data->name = $request['name'];
        $data->project = $request['project'];
        $data->phone = $request['phone'];
        $data->password = bcrypt('87654321');
        $data->save();

        Toastr::success('Approver berhasil ditambahkan!');

        return redirect()->route('admin.approver.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request);
        $data = Approver::where('id', $request['id'])->first();

        return view('admin-views.approver.view.view', compact('data'));
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
        // dd($request);
        $project = Approver::where('id', $request['id'])->first();
        $project->name = $request['name'];
        $project->project = $request['project'];
        $project->phone = $request['phone'];
        $project->save();
        Toastr::success('Approver berhasil diubah!');

        return redirect()->route('admin.approver.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request);
        $data = Approver::where('id', $request['id'])->first();
        $data->delete();
        Toastr::info('Approver berhasil dihapus!');

        return redirect()->back();
    }
}
