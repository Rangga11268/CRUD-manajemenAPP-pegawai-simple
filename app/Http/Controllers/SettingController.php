<?php

namespace App\Http\Controllers;


use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle App Logo Update
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('uploads/settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'app_logo'],
                ['value' => $path, 'type' => 'image', 'description' => 'Logo Aplikasi']
            );
        }

        // Handle other settings
        $settings = $request->except(['_token', 'app_logo']);
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
