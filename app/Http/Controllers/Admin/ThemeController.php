<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $activeTheme = Setting::where('key', 'active_theme')->value('value') ?? 'default';
        $themes = ['default', 'dark', 'light'];

        return view('admin.themes.index', compact('activeTheme', 'themes'));
    }

    public function changeTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:default,dark,light',
        ]);

        Setting::updateOrCreate(
            ['key' => 'active_theme'],
            ['value' => $request->theme]
        );

        return redirect()->back()->with('success', 'Theme updated successfully!');
    }
}
