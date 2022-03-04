<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Customer;
use Illuminate\Http\Request;

class RoleCheckController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $worker = Customer::where('phone', $request['phone'])->first();
        $approver = Approver::where('phone', $request['phone'])->first();

        if ($worker) {
            $cred = [
                'phone' => $request['phone'],
                'password' => $request['password'],
            ];

            $login = new CustomerController();

            $resp = $login->login($cred);
        } elseif ($approver) {
            $cred = [
                'phone' => $request['phone'],
                'password' => $request['password'],
            ];

            $login = new ApproverController();

            $resp = $login->login($cred);
        } else {
            return response()->json(['errors' => 'No Handphone tidak terdaftar'], 403);
        }

        return $resp;
    }
}
