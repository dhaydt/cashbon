<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Approver;
use App\Models\Customer;
use App\Models\Project;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        session()->put('title', 'Dashboard');
        $project = Project::get();
        $approv = Approver::get();
        $supplier = Customer::get();
        $admin = Admin::get();
        $data = ['project' => $project, 'approv' => $approv, 'supplier' => $supplier, 'admin' => $admin];

        return view('admin-views.system.dashboard', compact('data'));
    }
}
