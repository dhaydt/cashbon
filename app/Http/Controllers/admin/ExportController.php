<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbon;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start = $request['start-date'];
        $end = $request['end-date'];

        if ($start == $end) {
            $orders = Cashbon::where('created_at', 'like', "%{$start}%")->with('pekerja', 'project', 'approver')->get();
        } else {
            $orders = Cashbon::whereBetween('created_at', [$start, $end])->with('pekerja', 'project', 'approver')->get();
        }
        dd($orders);
    }
}
