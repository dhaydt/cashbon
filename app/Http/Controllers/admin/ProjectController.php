<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
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

        return view('admin-views.project.list', compact('admin', 'search'));
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
            'nilai' => 'required',
        ], [
            'nilai.required' => 'Nilai project dibutuhkan!',
            'name.required' => 'Nama project dibbutuhkan!',
        ]);

        $data = new Project();
        $data->name = $request['name'];
        $data->nilai_project = $request['nilai'];
        $data->description = $request['desc'];
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
        $project = Project::where('id', $request['id'])->first();
        $project->name = $request['name'];
        $project->nilai_project = $request['nilai'];
        $project->description = $request['desc'];
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
