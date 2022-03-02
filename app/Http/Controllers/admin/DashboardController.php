<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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

        return view('admin-views.system.dashboard');
    }
}
