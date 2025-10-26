<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppearanceController extends Controller
{
    public function index()
    {
        $logo = Setting::get('logo');
        $background = Setting::get('background');

        return view('dashboard.appearance', compact('logo', 'background'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'background' => 'nullable|image|max:5120',
        ]);

        // store logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            Setting::set('logo', $path);
        }

        // store background
        if ($request->hasFile('background')) {
            $file = $request->file('background');
            $filename = 'background_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            Setting::set('background', $path);
        }

        return back()->with('success', 'Logo dan background berhasil diperbarui.');
    }
}
