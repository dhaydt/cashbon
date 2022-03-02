<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Customer;
use App\Models\Project;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
            $admin = Project::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('project', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $admin = new Project();
        }

        session()->put('title', 'Daftar proyek');
        $admin = $admin->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        $worker = Customer::get();
        $app = Approver::get();

        return view('admin-views.project.list', compact('admin', 'search', 'worker', 'app'));
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
        // dd($request);
        $request->validate([
            'name' => 'required',
            'nilai' => 'required',
            'jenis' => 'required',
            'nomor' => 'required',
            'pekerja' => 'required',
            'approver' => 'required',
        ], [
            'nilai.required' => 'Nilai project dibutuhkan!',
            'name.required' => 'Nama project dibutuhkan!',
            'jenis.required' => 'Jenis pekerjaan dibutuhkan!',
            'nomor.required' => 'Nomor kontrak dibutuhkan!',
            'pekerja.required' => 'Pekerja project dibbutuhkan!',
            'approver.required' => 'Approver project dibbutuhkan!',
        ]);

        $worker = [];
        foreach ($request['pekerja'] as $p) {
            $work = Customer::where('id', $p)->first();
            $phone = $work->phone;
            $name = $work->name;
            $data = [
                'id' => $p,
                'phone' => $phone,
                'name' => $name,
            ];
            array_push($worker, $data);
        }

        $app = [];
        foreach ($request['approver'] as $a) {
            $work = Approver::where('id', $a)->first();
            $phone = $work->phone;
            $name = $work->name;
            $data = [
                'id' => $a,
                'phone' => $phone,
                'name' => $name,
            ];
            array_push($app, $data);
        }

        $data = new Project();
        $data->name = $request['name'];
        $data->nilai_project = $request['nilai'];
        $data->jenis = $request['jenis'];
        $data->nomor = $request['nomor'];
        $data->pekerja = json_encode($worker);
        $data->approver = json_encode($app);
        $data->save();

        Toastr::success('Proyek berhasil ditambahkan!');

        return redirect()->route('admin.project.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request);
        $data = Project::where('id', $request['id'])->first();

        return view('admin-views.project.view.view', compact('data'));
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
        $worker = [];
        foreach ($request['pekerja'] as $p) {
            $work = Customer::where('id', $p)->first();
            $phone = $work->phone;
            $name = $work->name;
            $data = [
                'id' => $p,
                'phone' => $phone,
                'name' => $name,
            ];
            array_push($worker, $data);
        }

        $app = [];
        foreach ($request['approver'] as $a) {
            $work = Approver::where('id', $a)->first();
            $phone = $work->phone;
            $name = $work->name;
            $data = [
                'id' => $a,
                'phone' => $phone,
                'name' => $name,
            ];
            array_push($app, $data);
        }
        $project = Project::where('id', $request['id'])->first();
        $project->name = $request['name'];
        $project->nilai_project = $request['nilai'];
        $project->pekerja = json_encode($worker);
        $project->approver = json_encode($app);
        $project->jenis = $request['jenis'];
        $project->nomor = $request['nomor'];
        $project->save();
        Toastr::success('Proyek berhasil diubah!');

        return redirect()->route('admin.project.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request);
        $data = Project::where('id', $request['id'])->first();
        $data->delete();
        Toastr::info('Proyek berhasil dihapus!');

        return redirect()->back();
    }
}
