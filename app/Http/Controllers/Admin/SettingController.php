<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name'               => Setting::get('app_name', 'Stockify Project'),
            'app_description'        => Setting::get('app_description', ''),
            'app_logo'               => Setting::get('app_logo'),
            'low_stock_notification' => Setting::get('low_stock_notification', 'true'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name'        => 'required|string|max:255',
            'app_description' => 'nullable|string|max:500',
            'app_logo'        => 'nullable|image|max:2048',
        ]);

        Setting::set('app_name', $request->app_name);
        Setting::set('app_description', $request->app_description ?? '');
        Setting::set('low_stock_notification', $request->has('low_stock_notification') ? 'true' : 'false');

        if ($request->hasFile('app_logo')) {
            $oldLogo = Setting::get('app_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $path);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}