<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request; // ✅ Needed for $request
use Illuminate\Support\Facades\Hash; // ✅ Needed for Hash::make()
use Inertia\Inertia;

class OrganizationController extends Controller
{
    public function dashboard()
{
    $user = auth()->user();

    // Counts for top cards
    $myEvents = \App\Models\Event::where('user_id', $user->id)->count();

    $approvedEvents = \App\Models\Event::where('user_id', $user->id)
        ->where('status', 'Approved')
        ->count();

    $pendingEvents = \App\Models\Event::where('user_id', $user->id)
        ->where('status', 'Pending')
        ->count();

    $totalStudents = \App\Models\Student::where('user_id', $user->id)->count();

    // Total collected (all paid)
    $totalCollected = \DB::table('event_student')
        ->join('events', 'event_student.event_id', '=', 'events.id')
        ->where('events.user_id', $user->id)
        ->where('event_student.status', 'Paid')
        ->sum('event_student.amount_paid');

    // Fetch all approved events with computed collection stats
    $approvedEventStats = \App\Models\Event::where('user_id', $user->id)
        ->where('status', 'Approved')
        ->get()
        ->map(function ($event) use ($user) {
            // Target students matching event's filters
            $targetStudents = \App\Models\Student::where('user_id', $user->id)
                ->where('course', $event->course)
                ->where('yearlevel', $event->year_level)
                ->count();

            $desiredAmount = $targetStudents * $event->event_fee;

            $currentCollected = \DB::table('event_student')
                ->where('event_id', $event->id)
                ->where('status', 'Paid')
                ->sum('amount_paid');

            $percentage = $desiredAmount > 0
                ? round(($currentCollected / $desiredAmount) * 100, 1)
                : 0;

            return [
                'event_name' => $event->event_name,
                'desired_amount' => $desiredAmount,
                'current_collected' => $currentCollected,
                'percentage' => $percentage,
                'event_date' => $event->event_date,
            ];
        });

        return Inertia::render('Organization/Dashboard', [
            'myEvents' => $myEvents,
            'approvedEvents' => $approvedEvents,
            'pendingEvents' => $pendingEvents,
            'numberOfStudents' => $totalStudents, // ✅ renamed key
            'totalCollected' => $totalCollected,
            'approvedEventStats' => $approvedEventStats,
        ]);
}


    public function profile()
    {
        $organization = auth()->user();
        return Inertia::render('Organization/Profile', [
            'organization' => $organization
        ]);
    }

    // Update profile (including password)
    public function updateProfile(Request $request)
    {
        $organization = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $organization->id],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $organization->name = $request->name;
        $organization->email = $request->email;

        if ($request->password) {
            $organization->password = Hash::make($request->password);
        }

        $organization->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    // Update password only (optional)
    public function updatePassword(Request $request)
    {
        $organization = auth()->user();

        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $organization->password = Hash::make($request->password);
        $organization->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
