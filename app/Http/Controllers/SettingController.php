<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $app_name = Setting::get('app_name', config('app.name'));
        $app_logo = Setting::get('app_logo');
        $app_favicon = Setting::get('app_favicon');

        return view('admin.settings.index', compact('app_name', 'app_logo', 'app_favicon'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'app_favicon' => 'nullable|image|mimes:ico,png,svg|max:1024',
        ]);

        Setting::set('app_name', $request->app_name);

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $path);
        }

        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            Setting::set('app_favicon', $path);
        }

        return redirect()->route('settings.index')->with('success', 'Configurações atualizadas com sucesso.');
    }
}
