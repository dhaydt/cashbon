<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::get();
        session()->put('title', 'Payment Config');

        return view('admin-views.payment.paymentList', compact('payment'));
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Payment::find($request->id);
            $banner->status = $request->status;
            $banner->save();
            $data = $request->status;

            return response()->json($data);
        }
    }
}
