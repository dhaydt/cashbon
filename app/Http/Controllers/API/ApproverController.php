<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApproverController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $driver = Approver::where('phone', $request->phone)->first();

        if (!$driver || !Hash::check($request->password, $driver->password)) {
            return response()->json(['errors' => 'No Handphone atau Password salah'], 403);
        }

        $id = $driver->id;
        $project = Project::whereJsonContains('approver', ['id' => (string) $id])->get(['id', 'name']);

        $data = $driver->where('phone', $request->phone)->get(['id', 'name', 'phone']);

        return response()->json([
            'role' => 'approver',
            'user_data' => $data,
            'project' => $project,
            'token' => $driver->createToken('mobile', ['role:approver'])->plainTextToken,
        ]);
    }
}
