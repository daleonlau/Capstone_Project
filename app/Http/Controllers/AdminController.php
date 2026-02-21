<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $organizations = User::where('role', 'organization')->count();

        return Inertia::render('Admin/Dashboard', [
            'totalOrganizations' => $organizations,
        ]);
    }

    public function indexOrganizations()
    {
        $organizations = User::where('role', 'organization')->get();

        return Inertia::render('Admin/Organizations', [
            'organizations' => $organizations,
        ]);
    }

    public function storeOrganization(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'organization',
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization registered successfully!');
    }

    public function updatePassword(Request $request, User $organization)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $organization->password = Hash::make($request->password);
        $organization->save();

        return redirect()->back()->with('success', 'Organization password updated successfully!');
    }

    public function destroyOrganization(User $organization)
    {
        if ($organization->role === 'organization') {
            $organization->delete();
        }

        return redirect()->back()->with('success', 'Organization deleted successfully!');
    }

    public function profile()
    {
        $admin = auth()->user();
        return Inertia::render('Admin/Profile', [
            'admin' => $admin
        ]);
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
