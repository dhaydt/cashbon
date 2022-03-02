<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function maintenance_mode()
    {
        $maintenance_mode = BusinessSetting::where('type', 'maintenance_mode')->first();
        if (isset($maintenance_mode) == false) {
            DB::table('business_settings')->insert([
                'type' => 'maintenance_mode',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('business_settings')->where(['type' => 'maintenance_mode'])->update([
                'type' => 'maintenance_mode',
                'value' => $maintenance_mode->value == 1 ? 0 : 1,
                'updated_at' => now(),
            ]);
        }

        if (isset($maintenance_mode) && $maintenance_mode->value) {
            return response()->json(['message' => 'Maintenance is off.']);
        }

        return response()->json(['message' => 'Maintenance is on.']);
    }
}
