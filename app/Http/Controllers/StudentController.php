<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::where('user_id', auth()->id())
                           ->orderBy('created_at','desc')
                           ->get();

        return Inertia::render('Organization/Students/Students', [
            'students' => $students
        ]);
    }

    // Store a new student
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string',
            'firstname'  => 'required|string|max:255',
            'lastname'   => 'required|string|max:255',
            'course'     => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'yearlevel'  => 'required|string|in:firstyear,secondyear,thirdyear,fourthyear',
        ]);

        // Ensure unique per organization
        $exists = Student::where('student_id', $validated['student_id'])
                         ->where('user_id', auth()->id())
                         ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['student_id' => 'This student already exists in your organization.']);
        }

        Student::create(array_merge($validated, [
            'user_id' => auth()->id(),
        ]));

        return redirect()->back()->with('success', 'Student added successfully.');
    }

    // Update student
    public function update(Request $request, $student_id)
    {
        $student = Student::where('student_id', $student_id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $validated = $request->validate([
            'firstname'  => 'required|string|max:255',
            'lastname'   => 'required|string|max:255',
            'course'     => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'yearlevel'  => 'required|string|in:firstyear,secondyear,thirdyear,fourthyear',
        ]);

        $student->update($validated);

        return redirect()->back()->with('success', 'Student updated successfully.');
    }

    // Delete student
    public function destroy($student_id)
    {
        $student = Student::where('student_id', $student_id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

    // Bulk import
    public function bulkStore(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv,txt|max:2048']);

        Excel::import(new StudentsImport(auth()->id()), $request->file('file'));

        return redirect()->back()->with('success', 'Students uploaded successfully.');
    }
}
