<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThemeSettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('theme_settings')
            ->select('key_name', 'value','label','type','version')
            ->get();

        return view('publication::admin.theme-setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->input('settings', []);

        if (empty($data)) {
            return redirect()->back()->with('error', 'No settings data received!');
        }

        try {
            foreach ($data as $key => $value) {
                DB::table('theme_settings')->updateOrInsert(
                    ['key_name' => $key],
                    ['value' => $value, 'updated_at' => now()]
                );
            }

            return redirect()->back()->with('success', 'Theme settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating settings: ' . $e->getMessage());
        }
    }
}
