<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $organization = $request->user(); // Assuming organization users are authenticated via default guard

        return Inertia::render('Organization/Profile', [
            'organization' => $organization,
        ]);
    }

    public function update(Request $request)
    {
        $organization = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $organization->id,
        ]);

        $organization->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $organization = $request->user();

        $data = $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);

        $organization->password = Hash::make($data['password']);
        $organization->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
