<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{
    // Show all events (Approved + Finished)
    public function index()
    {
        $events = Event::where('user_id', auth()->id())
            ->whereIn('status', ['Approved', 'Finished', 'Completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Organization/Collections/Collection', [
            'events' => $events,
            'selectedEvent' => null,
            'students' => [],
        ]);
    }

    // Show selected event and its matching students
    public function show(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        // Fetch students under the same course and year level as the event
        $students = Student::where('students.user_id', auth()->id())
            ->where('students.course', $event->course)
            ->where('students.yearlevel', $event->year_level)
            ->get();

        // Load payment pivot data for this event
        $students->load(['events' => function ($q) use ($event) {
            $q->where('event_id', $event->id);
        }]);

        // Always show all approved/finished events for switching
        $events = Event::where('user_id', auth()->id())
            ->whereIn('status', ['Approved', 'Finished', 'Completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Organization/Collections/Collection', [
            'events' => $events,
            'selectedEvent' => $event,
            'students' => $students,
        ]);
    }

    // Process payment for a student
    public function pay(Event $event, $student_id)
    {
        // Ensure student belongs to this org
        $student = Student::where('student_id', $student_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        // Prevent duplicate payment
        $alreadyPaid = $event->students()
            ->where('event_student.student_id', $student->student_id)
            ->wherePivot('status', 'Paid')
            ->exists();

        if ($alreadyPaid) {
            return back()->with('error', 'This student has already paid for this event.');
        }

        // Record payment
        $event->students()->syncWithoutDetaching([
            $student->student_id => [
                'status' => 'Paid',
                'amount_paid' => $event->event_fee,
                'user_id' => auth()->id(),
            ],
        ]);

        return back()->with('success', 'Payment updated successfully.');
    }
}
