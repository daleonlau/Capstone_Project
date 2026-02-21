<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'student_id' => $row['student_id'],
            'firstname'  => $row['firstname'],
            'lastname'   => $row['lastname'],
            'course'     => $row['course'],
            'department' => $row['department'] ?? null,
            'yearlevel'  => $row['yearlevel'],
            'user_id'    => Auth::id(), // automatically assign organization
        ]);
    }
}
