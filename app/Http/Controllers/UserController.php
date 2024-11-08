<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line

class UserController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->update($data); // Use Auth facade to access user

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}

